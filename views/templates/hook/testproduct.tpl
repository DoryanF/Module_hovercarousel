{*{extends file='catalog/_partials/miniatures/product.tpl'}
{block name='product_thumbnail'}
{parent}*}

{if $switch_hover == 1}
<div class="second-image">
        <img src="{$img_url}" alt="{$product_name}" />
</div>
{/if}

{if $switch_carousel == 1}

    <div id="carouselHoverCarousel" class="carousel slide" data-ride="carousel" data-interval="{$speed_interval}">
        
        <a href="{$product_link}" class="thumbnail product-thumbnail carousel-thumbnail">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{$cover_url}"
                    alt="{$product_name}">
                </div>

                {foreach from=$urls_images item=$url_image}
                <div class="carousel-item">
                    <img class="d-block w-100" src="{$url_image}" alt="{$product_name}">
                </div>
                {/foreach}
            </div>
        </a>

    {if $switch_carousel_arrow == 1}
        <div id="arrow_carousel">

            <a class="carousel-control-prev" href="#carouselHoverCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" style="background-color:{$color_carousel_arrow};" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#carouselHoverCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" style="background-color:{$color_carousel_arrow};" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    {/if}

  </div>

{/if}

