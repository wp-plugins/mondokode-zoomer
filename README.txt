=== MondoKode-Zoomer ===
================================
Contributors: mcormier 
Donate link: http://www.nsnt.ca/ 
Tags: zoom, highlight, code, kode, formatting, overlay  
Requires at least: 2.8  
Tested up to: 2.8  
Stable tag: 0.1  

MondoKode-Zoomer provides an overlay window for kode formatted with the
[wp_syntax](http://wordpress.org/extend/plugins/wp-syntax/) plugin.

== Description ==
-------------------------

MondoKode-Zoomer was created for blogs that have a narrow reading column but will
be embedding code using the wp_syntax plugin.  A narrow column is a pleasure to read
and there is a reason for this.

> "That's why newspapers have narrow columns: It makes them faster to read."

-  Amar Sagoo [Tofu web page](http://amarsagoo.info/tofu/)

However, it is a nuissance to have a narrow width constraint when presenting kode.  I've caught myself 
reformatting kode on numerous occasions in hope of eliminating the horizontal scrollbar.
With this plugin you can spend more time sharing kode and less time formatting it for a skinny column.


== Basic Usage ==
-------------------------

Add a zoom attribute to a pre block that wp_syntax formats.  Valid values for the 
attribute are "yes" and "no".

 `<pre lang="LANGUAGE" zoom="yes">` 
 
 The attribute is not required. When it is not present zoom is not enabled.

== Installation ==
-------------------------

1. Upload MondoKode-zoomer to your WordPress plugins directory, usually `wp-content/plugins/` and unzip the file.  It will create a `wp-content/plugins/MondoKode-zoomer/` directory.
1. Copy `wp_syntax_Override/wp-syntax.php` to `wp-content/plugins/wp-syntax`.  The reasons for doing this are explained 
in the wp-syntax changes section below.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Create a post/page that contains a code snippet following the [proper usage syntax](http://wordpress.org/extend/plugins/wp-syntax/other_notes/)
and add the zoom attribute if you want to make it zoomable.


== Wp-syntax Changes ==
-------------------------

To allow wp_syntax and MondoKode-zoomer to play nicely you need to use the version of wp-syntax.php
provided with this plugin.  The changes to the file are listed here, do a diff comparison with the
original to see the changes in detail.

1. zoom is added as a supported attribute in $allowedposttags and $allowedtags.
1. The regular expression in the wp_syntax_before_filter function has been modified to allow the zoom attributed. 
1. In the wp_syntax_highlight function some logic was added to add the wp_syntax_zoom css class to 
a div block if zoom was enabled.


== Screenshots ==
-------------------------
Kode with zoom enabled 

![Screenshot 1](http://torch.cs.dal.ca/~mcormier/GitHub/MondoKode-Zoomer/screenshot1.png)

Zoomed Kode

![Screenshot 2](http://torch.cs.dal.ca/~mcormier/GitHub/MondoKode-Zoomer/ScreenShot2.jpg)




== Usage ==
-------------------------
Use regular wp-syntax formatting commands but add the zoom attribute if you want the kode to zoom.
It's that simple.

**Example 1: Enabling zoom**

    <pre lang="php" zoom="yes">
    <div id="foo">
    <?php
      function foo() {
        echo "Hello World!\\n";
      }
    ?>
    </div>
    </pre>


**Example 2: Explicitly disabling zoom**

    <pre lang="java" zoom="no" >
    public class Hello {
      public static void main(String[] args) {
        System.out.println("Hello World!");
      }
    }
    </pre>

**Example 3: Zoom is implicity disabled because the attribute does not exist**

    <pre lang="ruby" line="18">
    class Example
      def example(arg1)
        return "Hello: " + arg1.to_s
      end
    end
    </pre>






== Frequently Asked Questions ==
-------------------------
Empty.

== Changelog ==
-------------------------

**0.1** : First release; 
