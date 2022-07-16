<?php

// #################### PFLICHT!! namespace ####################
namespace DateifabrikLicenseCalc\Subscriber;

// ####################  PFLICHT!! Implementierung des SubscriberInterface ####################
use Enlight\Event\SubscriberInterface;
use Doctrine\ORM\EntityManager;
use Shopware\Bundle\StoreFrontBundle\Struct\Attribute;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Customer\Customer;
use Shopware\Models\Attribute\Configuration;



class CheckoutConfirmSubscriber implements SubscriberInterface
{

    private $single_weight;
    private $material;
    private $weight_field_name = 'isy_einzelgewicht';
    private $materialNameService;


    // materialArray = Vorgabewerte zum Abgleich, entsprechen den keys im Freitextfeld
    private $materialArray = array(
        'alu',
        'cardboard',
        'other_material',
        'plastic',
        'other_composites'
    );

    //  #################### PFLICHT!! function getSubscribedEvents ####################
    public static function getSubscribedEvents()
    {

        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onPostDispatchFrontendCheckoutConfirm',
            'Enlight_Controller_Action_Frontend_Checkout_Finish' => 'onFrontendCheckoutFinish'
        ];

    }

    // \Enlight_Event_EventArgs $args
    public function onPostDispatchFrontendCheckoutConfirm(\Enlight_Event_EventArgs $args)
    {

        // Status aus DB s_user_attributes holen
        // Dazu wird die UserId benötigt, die holen wir aus den Basket-Daten

        $basket = $this->getBasket();
        $userId = $basket['content'][0]['userID'];
        /*
        $status = 'SELECT dateifabrik_verpackg_license_every_order FROM s_user_attributes WHERE userID = ?';
        $currentStatus = Shopware()->db()->fetchOne($status,$userId);
        */
        if(!empty($userId)){
            $currentStatus = $this->getUserAttribute($userId);
        }


/*
        echo "<pre>";
        print_r($currentStatus);
        echo "</pre>";
        die();
*/
        // hole die Daten vom Frontend
        $checkoutConfirmController = $args->getSubject();

        // views Ordner registrieren
        $view = $checkoutConfirmController->View();
        $view->addTemplateDir(__DIR__ . '/../Resources/views/');







        // einen eigenen Service nutzen
        /*
        $hello = $checkoutConfirmController->get('dateifabrik_license_calc.services.test_service');
        $hello->hello();

        die('Externer Service wurde aufgerufen.');
        */



        /* ##################################################### */
        /* #################### BASKET DATA #################### */
        /* ##################################################### */



/*
        echo "<pre>";
        print_r($basket['content']);
        echo "</pre>";
        die();
*/

        // Materialnamen aus der DB holen für Datenvergleich weiter unten
        $this->materialNameService = $checkoutConfirmController->get('dateifabrik_license_calc.services.material_name_service');
        $label = "Material"; // TODO: Name des Labels möglichst aus der Plugin Config holen!!!
        $column_name = $this->materialNameService->getColumnName($label); // column_name = z.B. "material" oder "isy_license_weight"
        $array_store = $this->materialNameService->getArrayStore($column_name[0]); // array_store = array mit Objekten, z.B. key->alu value->aluminium
        foreach(json_decode($array_store[0]) as $item){
            $material_names[$item->key] = $item->value; // ist jetzt Array[alu] => Aluminium
        }

        foreach($basket['content'] as $basket_content)
        {

            $userId = $basket_content['userID'];

            //$this->getMail($userId);

            $quantity = $basket_content['quantity'];
            $article_name = $basket_content['articlename'];
            $purchase_unit = $basket_content['purchaseunit'];

            $this->single_weight = $basket_content['additional_details']['attributes']['core']->get($this->weight_field_name);

            $this->material = $basket_content['additional_details']['attributes']['core']->get($column_name[0]);
            if(in_array($this->material, $this->materialArray)){

                $material = (in_array($this->material, array_keys($material_names)) ? $material_names[$this->material] : FALSE); // ist z.B. alu in den array_keys von material_names ? dann gib mir material_names['alu']-Wert

                $total_item_weight = str_replace('.', ',', $quantity * $purchase_unit * floatval(str_replace(',', '.', $this->single_weight)));

                $weighting_for_you[] = array(
                    "article_name" => $article_name,
                    "material" => $material,
                    "quantity" => $quantity,
                    "purchase_unit" => intval($purchase_unit),
                    "single_weight" => $this->single_weight,
                    "total_item_weight" => $total_item_weight
                );

                $license_fee_total_weights[] = $total_item_weight;

            }
            else{
                continue;
            }

        }

        $license_fee_total_weight = array_sum(str_replace(',','.', $license_fee_total_weights)); // aus komma mach punkt zum rechnen


        if ($currentStatus == 1) {
            $view->assign('sLICENSEChecked', true);
        }

        $view->assign('weighting_for_you', $weighting_for_you);
        $view->assign('license_fee', str_replace('.',',', $license_fee_total_weight)); // aus punkt mach komma zum richtig ausgeben

    }


    public function getBasket(){
   		return Shopware()->Modules()->Basket()->sGetBasket();
   	}


    public function onFrontendCheckoutFinish(\Enlight_Event_EventArgs $args)
    {

        $basket = $this->getBasket();
		$userId = $basket['content'][0]['userID'];

        $subject = $args->getSubject();

        if($subject->Request()->getParam('meineLizenz') !== NULL){

            $sqlAccount = 'UPDATE s_user_attributes SET dateifabrik_verpackg_license_every_order = ? WHERE userID = ?';
            Shopware()->db()->query($sqlAccount,array(1, $userId));

        }
        else{
            $sqlAccount = 'UPDATE s_user_attributes SET dateifabrik_verpackg_license_every_order = ? WHERE userID = ?';
            Shopware()->db()->query($sqlAccount,array(NULL, $userId)); // nochmal das Feld checken, ob NULL überhaupt zugelassen ist
        }

    }


    public function getUserAttribute($userId)
    {

        // Get Customer
        $customerModel = Shopware()->Models()->getRepository('Shopware\Models\Customer\Customer');

        /** @var  $customer \Shopware\Models\Customer\Customer */
        $customer = $customerModel->findOneBy(array('id' => $userId));

        /** @var  $attribute \Shopware\Models\Attribute\Customer */
        $attribute = $customer->getAttribute()->getDateifabrikVerpackgLicenseEveryOrder();

        return $attribute;

    }



/*
    public function getMail($userId)
    {

        /** @var ModelManager $entityManager
        $entityManager = Shopware()->Container()->get('models');

        $customerRepository = $entityManager->getRepository(Customer::class);

        /** @var Customer $m
        $m = $customerRepository->findOneBy(['id' => $userId]);

        //echo "<pre>";
        //print_r($m->getEmail());
        //echo "</pre>";
        //die('mail');


    }
*/

}
