{extends file="smarty/toewsweb.tpl"}

{block name=content}
            <div class="portfolio_container">
{foreach $portfolio as $item}
  {if $item.category != $lastcat}
    {$lastcat = $item.category}
                <div class="category_header">
                    <span class="category_name">{$item.category}</span>.  <span class="category_description">{$item.description}</span>
                </div>
  {/if}
                <div class="portfolio_item" data-link="{$item.url}">
  {if $item.thumb_file}
                    <div class="portfolio_thumb">
                        <img src="{$item.thumb_file}" width="100" border="0"/>
                    </div>
  {/if}
                    <div class="portfolio_entry">
                        {$item.entry}
                    </div>
                    <br style="clear:both; height:0px"/>
                </div>
{/foreach}
            </div>
{/block}
