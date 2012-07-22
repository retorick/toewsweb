{extends 'smarty/toewsweb.tpl'}
{block name=content}
<script type="text/javascript" src="./js/exhibit.js"></script>

<!--
<div id="recent-blogs-box">
  <div class="tab-label">Recent Blogs</div>
  <div class="tab-content">
    {foreach $blog_posts as $post}
    <p><strong>{$post.post_title}</strong> {$post.date}</p>
    <p>{$post.content}</p>
    {/foreach}
  </div>
</div>
-->

<div id="portfolio-highlights-box">
  <div class="tab-label">Portfolio Highlights</div>
  <div class="tab-content">
    {foreach $portfolio_highlights as $item}
    <div class="portfolio-item">
      <p><a href="{$item.link}" data-id="{$item.id}"><img src="{$item.thumb_file}"/></a></p>
      <p>{$item.title}</p>
    </div>
    {/foreach}
    <br style="clear:both"/>
  </div>
</div>

<div id="code-samples-box">
  <div class="tab-label">Code Samples</div>
  <div class="tab-content">
    <p>Some of this is on Github, some on my own server.  Examples of code include PHP, JavaScript, CSS, Ruby, and Python.</p>
    <div id="code_samples">
      <dl id="exhibits">
        {foreach $code_samples as $key=>$sample}
        <dt id="{$key}"><a href="{$sample.link}">{$sample.title}</a></td>
        <dd>{$sample.brief_desc}
          <div class="details">
            {$sample.desc}
          </div>
        </dd>
        {/foreach}
      </dl>
      <br style="clear:both"/>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#exhibits dt a").click(function() { 
        CS.openSample(this.href);
        return false; 
    });
    
    $(".portfolio-item a").click(function() { 
        CS.openSample(this.href, $(this).attr('data-id'));
        return false; 
    });
    
});
</script>
{/block}
