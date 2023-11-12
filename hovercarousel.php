<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;

class HoverCarousel extends Module
{
    public function __construct()
    {
        $this->name = 'hovercarousel';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Doryan Fourrichon';
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        

        parent::__construct();
        $this->bootstrap = true;

        $this->displayName = $this->l('Hover Carousel');
        $this->description = $this->l('Module qui affiche ou non un carousel');

        $this->confirmUninstall = $this->l('Do you want to delete this module');
    }

    public function install()
    {
        if(!parent::install() ||
        !Configuration::updateValue('ACTIVATE_HOVER','0') ||
        !Configuration::updateValue('HOVER_CAROUSSEL','0') ||
        !Configuration::updateValue('HOVER_HOME','0') ||
        !Configuration::updateValue('HOVER_CATEGORY','0') ||
        !Configuration::updateValue('HOVER_MARQUES','0') ||
        !Configuration::updateValue('HOVER_TRANSITION','2000') ||
        !Configuration::updateValue('HOVER_INDICATOR','1') ||
        !Configuration::updateValue('HOVER_INDICATOR_COLOR','#ffffff') ||
        !$this->registerHook('displayHeader') ||
        !$this->registerHook('displayProductListReviews') ||
        !$this->registerHook('productImageHover')
        )
        {
            return false;
        }
            return true;
    }

    public function uninstall()
    {
        if(!parent::uninstall() ||
        !Configuration::deleteByName('ACTIVATE_HOVER') ||
        !Configuration::deleteByName('HOVER_CAROUSSEL') ||
        !Configuration::deleteByName('HOVER_HOME') ||
        !Configuration::deleteByName('HOVER_CATEGORY') ||
        !Configuration::deleteByName('HOVER_MARQUES') ||
        !Configuration::deleteByName('HOVER_TRANSITION') ||
        !Configuration::deleteByName('HOVER_INDICATOR') ||
        !Configuration::deleteByName('HOVER_INDICATOR_COLOR') ||
        !$this->unregisterHook('displayHeader') ||
        !$this->unregisterHook('displayProductListReviews') ||
        !$this->unregisterHook('productImageHover')        
        )
        {
            return false;
        }
            return true;
    }

    public function getContent()
    {

        return $this->postProcess().$this->renderForm();
    }

    public function renderForm()
    {
        $field_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings Hover Carousel'),
            ],
            'input' => [
                [
                    'type' => 'switch',
                        'label' => $this->l('Active Hover'),
                        'name' => 'ACTIVATE_HOVER',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Active Carousel'),
                        'name' => 'HOVER_CAROUSSEL',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Active Page Home'),
                        'name' => 'HOVER_HOME',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Active Page Category'),
                        'name' => 'HOVER_CATEGORY',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Active Page Marques'),
                        'name' => 'HOVER_MARQUES',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Vitesse de transition'),
                    'name' => 'HOVER_TRANSITION'
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Active flèche carousel'),
                        'name' => 'HOVER_INDICATOR',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    "type" => 'color',
                    'label' => $this->l('Choose color carousel fleche'),
                    'name' => 'HOVER_INDICATOR_COLOR'
                ]
            ],
            'submit' => [
                'title' => $this->l('save'),
                'class' => 'btn btn-primary',
                'name' => 'saving'
            ]
        ];

        $helper = new HelperForm();
        $helper->module  = $this;
        $helper->name_controller = $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->fields_value['ACTIVATE_HOVER'] = Configuration::get('ACTIVATE_HOVER');
        $helper->fields_value['HOVER_CAROUSSEL'] = Configuration::get('HOVER_CAROUSSEL');
        $helper->fields_value['HOVER_HOME'] = Configuration::get('HOVER_HOME');
        $helper->fields_value['HOVER_CATEGORY'] = Configuration::get('HOVER_CATEGORY');
        $helper->fields_value['HOVER_MARQUES'] = Configuration::get('HOVER_MARQUES');
        $helper->fields_value['HOVER_TRANSITION'] = Configuration::get('HOVER_TRANSITION');
        $helper->fields_value['HOVER_INDICATOR'] = Configuration::get('HOVER_INDICATOR');
        $helper->fields_value['HOVER_INDICATOR_COLOR'] = Configuration::get('HOVER_INDICATOR_COLOR');

        return $helper->generateForm($field_form);
    }

    public function postProcess()
    {
        if(Tools::isSubmit('saving'))
        {
            if(Validate::isBool(Tools::getValue('ACTIVATE_HOVER')) ||
            Validate::isBool(Tools::getValue('HOVER_CAROUSSEL')) ||
            Validate::isBool(Tools::getValue('HOVER_HOME')) ||
            Validate::isBool(Tools::getValue('HOVER_CATEGORY')) ||
            Validate::isBool(Tools::getValue('HOVER_MARQUES')) ||
            Validate::isBool(Tools::getValue('HOVER_INDICATOR')) ||
            Validate::isColor(Tools::getValue('HOVER_INDICATOR_COLOR')) ||
            Validate::isString(Tools::getValue('HOVER_TRANSITION'))
            )
            {
                Configuration::updateValue('ACTIVATE_HOVER',Tools::getValue('ACTIVATE_HOVER'));
                Configuration::updateValue('HOVER_CAROUSSEL',Tools::getValue('HOVER_CAROUSSEL'));
                Configuration::updateValue('HOVER_HOME',Tools::getValue('HOVER_HOME'));
                Configuration::updateValue('HOVER_CATEGORY',Tools::getValue('HOVER_CATEGORY'));
                Configuration::updateValue('HOVER_MARQUES',Tools::getValue('HOVER_MARQUES'));
                Configuration::updateValue('HOVER_TRANSITION',Tools::getValue('HOVER_TRANSITION'));
                Configuration::updateValue('HOVER_INDICATOR',Tools::getValue('HOVER_INDICATOR'));
                Configuration::updateValue('HOVER_INDICATOR_COLOR',Tools::getValue('HOVER_INDICATOR_COLOR'));

                return $this->displayConfirmation('Les champs ont bien été enregistré');
            }

        }
    }

    public function hookDisplayHeader($params)
    {
        if(Configuration::get('ACTIVATE_HOVER') == 1)
        {
            if(Configuration::get('HOVER_HOME') == 1 && Context::getContext()->controller->php_self == 'index')
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel.css');
            }
            else if(Configuration::get('HOVER_CATEGORY') == 1 && Context::getContext()->controller->php_self == 'category')
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel.css');
            }
            else if(Configuration::get('HOVER_MARQUES') == 1 && Context::getContext()->controller->php_self == 'manufacturer')
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel.css');
            }
            else
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel_no_active.css');
            }
        }
        elseif (Configuration::get('HOVER_CAROUSSEL') == 1) {

            if(Configuration::get('HOVER_HOME') == 1 && Context::getContext()->controller->php_self == 'index')
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel_carousel_active.css');
            }
            else if(Configuration::get('HOVER_CATEGORY') == 1 && Context::getContext()->controller->php_self == 'category')
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel_carousel_active.css');
            }
            else if(Configuration::get('HOVER_MARQUES') == 1 && Context::getContext()->controller->php_self == 'manufacturer')
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel_carousel_active.css');
            }
            else
            {
                $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel_no_active.css');
            }
        }
        else{
            $this->context->controller->registerStylesheet('css-hovercarousel','modules/hovercarousel/views/css/hovercarousel_no_active.css');
        }
        
        
    }


    public function hookProductImageHover($params)
    {
        $products = $this->getProducts();

        if(isset($params['id_product']))
        {
            $product_id=$params['id_product'];

            $sql= "SELECT id_image 
                   FROM  `"._DB_PREFIX_."image` 
                   WHERE  `id_product` =  $product_id AND (cover = 0 OR cover is null) ORDER BY  `position` ASC";
                   
            $image = Db::getInstance()->getRow($sql);

            $sql_cover= "SELECT id_image 
                        FROM  `"._DB_PREFIX_."image` 
                        WHERE  `id_product` =  $product_id AND cover = 1";

            $cover = Db::getInstance()->getRow($sql_cover);

            $sql_allimages = "SELECT id_image 
                            FROM  `"._DB_PREFIX_."image` 
                            WHERE  `id_product` =  $product_id";

            $all_images = Db::getInstance()->executeS($sql_allimages);

            if(!$image)
            {
                $sql= "SELECT id_image 
                       FROM  `"._DB_PREFIX_."image` 
                       WHERE  `id_product` =  $product_id AND cover =  1 ORDER BY  `position` ASC";
                $image = Db::getInstance()->getRow($sql);               
            }

            if($image){
                $product = new Product($product_id,false,$this->context->language->id,$this->context->shop->id);
                
                $urls_images = [];
                if(Configuration::get('HOVER_CAROUSSEL') == 1)
                {
                    foreach ($all_images as $image)
                    {
                        $urls_images[] = $this->context->link->getImageLink($product->link_rewrite, (int)$image['id_image'], method_exists('ImageType', 'getFormattedName') ? ImageType::getFormattedName('home') : 'home');
                    }
                }

                $this->smarty->assign(array(
                    'product_name' => $product->name,
                    'product_link' => $product->getLink(),
                    'images' => $image,
                    'cover' => $cover,
                    'urls_images' => $urls_images,
                    'cover_url' =>$this->context->link->getImageLink($product->link_rewrite, (int)$cover['id_image'], method_exists('ImageType', 'getFormattedName') ? ImageType::getFormattedName('home') : 'home'),
                    'products' => $products,
                    'img_url' => $this->context->link->getImageLink($product->link_rewrite, (int)$image['id_image'], method_exists('ImageType', 'getFormattedName') ? ImageType::getFormattedName('home') : 'home')
                ));               
            }
            else
                return;        
        }
        $this->smarty->assign(array(
            'switch_hover' => Configuration::get('ACTIVATE_HOVER'),
            'switch_carousel' => Configuration::get('HOVER_CAROUSSEL'),
            'speed_interval' => Configuration::get('HOVER_TRANSITION'),
            'switch_carousel_arrow' => Configuration::get('HOVER_INDICATOR'),
            'color_carousel_arrow' => Configuration::get('HOVER_INDICATOR_COLOR'),
        ));
        return $this->display(__FILE__, '/views/templates/hook/testproduct.tpl');
    }


    protected function getProducts()
    {
        $category = new Category((int) Configuration::get('HOME_FEATURED_CAT'));

        $searchProvider = new CategoryProductSearchProvider(
            $this->context->getTranslator(),
            $category
        );

        $context = new ProductSearchContext($this->context);

        $query = new ProductSearchQuery();

        $nProducts = Configuration::get('HOME_FEATURED_NBR');
        if ($nProducts < 0) {
            $nProducts = 12;
        }

        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
        ;

        if (Configuration::get('HOME_FEATURED_RANDOMIZE')) {
            $query->setSortOrder(SortOrder::random());
        } else {
            $query->setSortOrder(new SortOrder('product', 'position', 'asc'));
        }

        $result = $searchProvider->runQuery(
            $context,
            $query
        );

        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();

        $products_for_template = [];

        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
    }
}