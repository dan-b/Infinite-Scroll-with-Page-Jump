# Infinite Scroll with Page Jump

Load more content once reaching the end of a page. Allow the user to jump to a specific page. Update URL to reflect document changes.

## Demo
[View the demo](http://rubbishb.in/code/demos/2oxr89ki/)

This simple demo displays 10 articles per page from a total of 150 articles. If you scroll down it'll load the next page. If you hover over the small floating box you can enter a page number and click �Enter� to load that specific page.

## Motivation

I prefer infinite scroll over traditional pagination because it requires no pointing and clicking and allows for a nice, continuous flow of data. However I�ve noticed that most implementations lack certain helpful features taken for granted with pagination (e.g. going to page x or last rather than next; unique URLs for each page for bookmarking.) With this implementation I attempt to incorporate some features I think are essential for convenient navigation. 

### How is this different than other implementations?
- Ability to jump to a specific page
- URL change allowing bookmarking

## Acknowledgements

This script uses [jQuery](http://code.jquery.com/jquery.min.js)

A very helpful [scrolling function](http://www.abeautifulsite.net/blog/2010/01/smoothly-scroll-to-an-element-without-a-jquery-plugin/)

## Caveats

Loading a new page changes the URL, which might require URL rewriting in .htaccess, for example:
- RewriteRule ^articles/page/\d{1,3}$ articles/inex.php?page=$1
