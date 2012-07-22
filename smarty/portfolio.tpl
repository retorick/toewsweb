{extends file="smarty/toewsweb.tpl"}

{block name=content}
<script type="text/javascript" src="./js/exhibit.js"></script>
            <div class="portfolio-container">
{foreach $portfolio as $item}
  {if $item.category != $lastcat}
    {$lastcat = $item.category}
                <div class="category_header">
                    <span class="category_name">{$item.category}</span>.  <span class="category_description">{$item.description}</span>
                </div>
  {/if}
                <div class="portfolio-item" data-link="{$item.url}">
  {if $item.thumb_file}
                    <div class="portfolio-thumb">
                        <a href="{$item.link}" data-id="{{$item.id}}"><img src="{$item.thumb_file}" width="100" border="0"/></a>
                    </div>
  {/if}
                    <div class="portfolio-entry">
                        <a href="{$item.link}">{$item.title}</a>. {$item.entry}
                    </div>
                    <br style="clear:both; height:0px"/>
                </div>
{/foreach}
            </div>
<script type="text/javascript">
$(document).ready(function() {
    $(".portfolio-item a").click(function() { 
        CS.openSample(this.href, $(this).attr('data-id'));
        return false; 
    });
    
});
</script>
{/block}
