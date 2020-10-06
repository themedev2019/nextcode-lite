# NextCode Lite
NextCode s a best Options Framewok for Create Admin Options, Custom Posttype, Metabox, SubMenu, Nav Options, Profiles Options, Widgets, Shortcode, Comment Options, Texonomy Options etc. A Simple and Lightweight WordPress Option Framework for Themes and Plugins. Built in Object Oriented Programming paradigm with high number of custom fields and tons of options. Allows you to bring custom admin, metabox, taxonomy and customize settings to all of your pages, posts and categories. It's highly modern and advanced framework.
# Contents
<ul>
  <li><a href="#demo">Demo</a></li>
  <li><a href="#installation">Installation</a></li>
  <li><a href="#quick-start">Quick Start</a></li>
  <li><a href="#documentation">Documentation</a></li>
  <li><a href="#free-vs-premium">Free vs Premium</a></li>
  <li><a href="#support">Support</a></li>
  <li><a href="#release-notes">Release Notes</a></li>
  <li><a href="#license">License</a></li>
</ul>
# Demo
<p>For usage and examples, have a look at <g-emoji class="g-emoji" alias="rocket" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f680.png">🚀</g-emoji> <a href="http://nextcode.themedev.net/wp-login.php?login=demo" rel="nofollow">online demo</a></p>

# Quick Start
<p>Open your current theme <strong>functions.php</strong> file and paste this code.</p>
<div class="highlight highlight-text-html-php"><pre><span class="pl-c">// Check core class for avoid errors</span>
<span class="pl-k">if</span>( <span class="pl-en">class_exists</span>( <span class="pl-s">'CSF'</span> ) ) {

  <span class="pl-c">// Set a unique slug-like ID</span>
  <span class="pl-s1"><span class="pl-c1">$</span>prefix</span> = <span class="pl-s">'my_framework'</span>;

  <span class="pl-c">// Create options</span>
  <span class="pl-c1">CSF</span>::<span class="pl-en">createOptions</span>( <span class="pl-s1"><span class="pl-c1">$</span>prefix</span>, <span class="pl-en">array</span>(
    <span class="pl-s">'menu_title'</span> =&gt; <span class="pl-s">'My Framework'</span>,
    <span class="pl-s">'menu_slug'</span>  =&gt; <span class="pl-s">'my-framework'</span>,
  ) );

  <span class="pl-c">// Create a section</span>
  <span class="pl-c1">CSF</span>::<span class="pl-en">createSection</span>( <span class="pl-s1"><span class="pl-c1">$</span>prefix</span>, <span class="pl-en">array</span>(
    <span class="pl-s">'title'</span>  =&gt; <span class="pl-s">'Tab Title 1'</span>,
    <span class="pl-s">'fields'</span> =&gt; <span class="pl-en">array</span>(

      <span class="pl-c">// A text field</span>
      <span class="pl-en">array</span>(
        <span class="pl-s">'id'</span>    =&gt; <span class="pl-s">'opt-text'</span>,
        <span class="pl-s">'type'</span>  =&gt; <span class="pl-s">'text'</span>,
        <span class="pl-s">'title'</span> =&gt; <span class="pl-s">'Simple Text'</span>,
      ),

    )
  ) );

  <span class="pl-c">// Create a section</span>
  <span class="pl-c1">CSF</span>::<span class="pl-en">createSection</span>( <span class="pl-s1"><span class="pl-c1">$</span>prefix</span>, <span class="pl-en">array</span>(
    <span class="pl-s">'title'</span>  =&gt; <span class="pl-s">'Tab Title 2'</span>,
    <span class="pl-s">'fields'</span> =&gt; <span class="pl-en">array</span>(

      <span class="pl-c">// A textarea field</span>
      <span class="pl-en">array</span>(
        <span class="pl-s">'id'</span>    =&gt; <span class="pl-s">'opt-textarea'</span>,
        <span class="pl-s">'type'</span>  =&gt; <span class="pl-s">'textarea'</span>,
        <span class="pl-s">'title'</span> =&gt; <span class="pl-s">'Simple Textarea'</span>,
      ),

    )
  ) );

}</pre></div>
