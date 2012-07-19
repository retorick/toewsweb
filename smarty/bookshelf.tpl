{extends 'smarty/toewsweb.tpl'}
{block name=content}
<script type="text/javascript" src="./js/bookshelf.js"></script>
<div class="general booklist">
<p style="padding-bottom:10px; border-bottom:1px dotted gray; margin-bottom:20px;">The content is this page is extracted from the good<b>reads</b> RSS feed for my "Professional Development" bookshelf.</p>

    {foreach $books as $book}
<div class="book_cover">
  <img src="{$book.image}" />
</div>
<div class="book_info">
  <div class="book_title">           
    <h2>{$book.title}</h2>
  </div>
  <p class="author">{$book.author}</p>
  <p class="thoughts_intro">{$book.thoughts_intro}</p>
</div>
<div id="thoughts_{$book.ndx}" class="thoughts">
  <div class="thoughts_masthead" style="overflow:hidden">
    <div style="float:left; width:60px; margin-bottom:-500px; padding-bottom:500px">
      <img src="{$book.image}" />
    </div>
    <div style="float:left; width:300px; margin-bottom:-500px; padding-bottom:500px">
      <p style="margin-top:0; padding-top:0"><b>{$book.title}</b>, <i>{$book.author}</i></p>
      <p>My thoughts...</p>
    </div>
    <div style="float:right; margin-bottom:-500px; padding-bottom:500px">
      <img src="/images/close_btn.gif"/>
    </div>
    <br style="clear:both"/>
  </div>
{$book.thoughts}
</div>
<br style="clear:both"/>
    {/foreach}

</div>
{/block}
