$(document).ready(function() {
/*
    This was added to work with Wordpress blog posts containing illustrative code.
    The Wordpress editor inserts the <code> tag to indicate code; and, one must
    use the CSS white-space property to treat space as literal for indents.
    However, if one wants a uniform background for the block of text, the
    code {white-space: pre-wrap;} style doesn't work as desired, and one gets
    a block per line, rather than a block containing all lines.

    My solution here is to wrap the <code> tag inside a <blockquote> tag
    and format the <blockquote> tag with the background, border, padding,
    and whatever, to give the illustrative code the desired appearance.

    I use <blockquote> because this is another Wordpress insertion.
*/
    $('code').wrap('<blockquote>');
});
