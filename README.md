## Asides

Asides is a MODX Extra allowing you (and your clients) to easyly manage "asides" on a website.
You'll be able to quickly create chunks without having acces to the Elements tab.

## Configuration

Now, you'll want to change references to Asides in the files in your
new copied-from-Asides repo to whatever name of your new Extra will be. Once
you've done that, you can create some System Settings:

- 'mynamespace.core_path' - Point to /path/to/my/extra/core/components/extra/
- 'mynamespace.assets_url' - /path/to/my/extra/assets/components/extra/

Then clear the cache. This will tell the Extra to look for the files located
in these directories, allowing you to develop outside of the MODx webroot!

## Information

Note that if you git archive from this repository, you may not need all of its
functionality. This Extra contains files and the setup to do the following:

- Integrates a custom table of "Items"
- A snippet listing Items sorted by name and templated with a chunk
- A custom manager page to manage Items on

If you do not require all of this functionality, simply remove it and change the
appropriate code.

Also, you'll want to change all the references of 'Asides' to whatever the
name of your component is.

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