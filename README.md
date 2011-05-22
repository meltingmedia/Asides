## Asides

Asides is a MODX Extra allowing you (and your clients) to easily manage "asides" on a website.
You'll be able to quickly create chunks without having access to the Elements tab (and even without the new_chunk
right).

## Configuration

* Install via package manager.
* Setup the asides.categoryId system setting to fit your needs (indicates the category ID where your chunks to be used
as asides will be stored).
* set aside TV input option value at `@EVAL return $modx->runSnippet('getAside');`
* allow aside TV to access your desired templates
* in those templates, set `[[showAside? &chunks=```[[*aside]]```]]`
* you now should be good to go!

## Credits

This Extra is base on some MODX community members, see :
- http://wiki.modxcms.com/index.php/Create_TV-Based_Chunks
It also makes use of MadeMyDay's sortable checkbox TV :
- https://github.com/MadeMyDay/checkboxSortable
This Extra is, of course, based on the exellent modExtra from Shaun McCormick :
- https://github.com/splittingred/modExtra

## Copyright Information

Asides is distributed as GPL (as MODx Revolution is), but the copyright owner
(Romain Tripault) grants all users of Asides the ability to modify, distribute
and use Asides in MODX development as they see fit, as long as attribution
is given somewhere in the distributed source of all derivative works.