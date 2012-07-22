{extends 'smarty/toewsweb.tpl'}
{block name=content}
<script type="text/javascript" src="./js/exhibit.js"></script>

<div id="code_samples">
  <dl id="exhibits">
    {foreach $samples as $key=>$sample}
    <dt id="{$key}"><a href="{$sample.link}">{$sample.title}</a></dt>
    <dd>{$sample.brief_desc}
      <div class="details">
        {$sample.desc}
      </div>
    </dd>
    {/foreach}
  </dl>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#exhibits dt").mouseover(CS.initDescShow);
    $("#exhibits dt").mouseout(CS.initDescHide);
    $("#exhibits dt a").click(function() { 
        CS.openSample(this.href);
        return false; 
    });
    
});
</script>
{/block}
