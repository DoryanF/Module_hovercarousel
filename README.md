# Hover Carousel

Hover Carousel est un module Prestashop qui rajoute un effet hover et/ou un carousel aux images des produits

## Installation

Rajouter cette ligne dans le fichier themes/classic/templates/catalog/_partials/miniatures/product.tpl

```php
{hook h='productImageHover' id_product = $product.id_product}
```
comme dans cette exemple:
```php
{if $product.cover}
            <a href="{$product.url}" class="thumbnail product-thumbnail">
              <img
                src="{$product.cover.bySize.home_default.url}"
                alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                loading="lazy"
                data-full-size-image-url="{$product.cover.large.url}"
                width="{$product.cover.bySize.home_default.width}"
                height="{$product.cover.bySize.home_default.height}"
              />
            </a>
              {hook h='productImageHover' id_product = $product.id_product}            
          {else}
            <a href="{$product.url}" class="thumbnail product-thumbnail">
              <img
                src="{$urls.no_picture_image.bySize.home_default.url}"
                loading="lazy"
                width="{$urls.no_picture_image.bySize.home_default.width}"
                height="{$urls.no_picture_image.bySize.home_default.height}"
              />
            </a>
          {/if}
```
Installer le module, et tout devrais fonctionner
