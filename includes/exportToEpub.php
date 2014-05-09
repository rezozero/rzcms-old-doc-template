<?php 
/**
 * Copyright REZO ZERO 2013
 * 
 * This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License. 
 * 
 * Ce(tte) œuvre est mise à disposition selon les termes
 * de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Pas de Modification 3.0 France.
 *
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-nd/3.0/
 * or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 * 
 *
 * @file exportToEpub.php
 * @copyright REZO ZERO 2013
 * @author Ambroise Maupate
 */
// ePub uses XHTML 1.1, preferably strict.
$content_start =
  "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
. "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n"
. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\">\n"
. "<head>"
. "<meta http-equiv=\"Content-Type\" content=\"application/xhtml+xml; charset=utf-8\" />\n"
. "<title>".rz_setting::get("site_title")."</title>\n"
//. "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />\n"
. "</head>\n"
. "<body>\n";

$bookEnd = "</body>\n</html>";

//include_once(TEMPLATE_FOLDER."/includes/PHPePub/EPub.250.php");
include rz_core::getVendorFolder(true)."phpepub/Epub.class.php";

$book = new Epub();

// Title and Identifier are mandatory!
$book->setTitle(rz_setting::get("site_title"));
//$book->setIdentifier(rz_core::getBaseFolder()); // Could also be the ISBN number, prefered for published books, or a UUID.
$book->setLanguage("fr-FR"); // Not needed, but included for the example, Language is mandatory, but EPub defaults to "en". Use RFC3066 Language codes, such as "en", "da", "fr" etc.
$book->setDescription(rz_setting::get("meta_description"));
$book->setAuthor("Ambroise Maupate");
$book->setCreator("Ambroise Maupate");
$book->setPublisher("REZO ZERO", "http://www.rezo-zero.com/"); // I hope this is a non existant address :)
$book->setDate(time()); // Strictly not needed as the book date defaults to time().
$book->setRights("Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License."); // As this is generated, this _could_ contain the name or licence information of the user who purchased the book, if needed. If this is used that way, the identifier must also be made unique for the book.
$book->setSourceURL(rz_core::getBaseFolder());


/*$css = new Epub_Element_Css();
$css->setSrc(TEMPLATE_CSS_FOLDER."/style.css");
$css->setFile('css/style.css');
$book->addCss($css);*/

/*
 * Cover
 */
$image = new rz_document(array('name'=>'admin-image'));
$coverImage = new Epub_Element_Image();
$coverImage->setSrc(rz_core::getBaseFolder(true).'documents/'.$image->url);
$coverImage->setFile('image/'.$image->url);
$book->addImage($coverImage);

ob_start();
echo $content_start;
if ($image !== null && $image->exists()) {
	echo "<img src=\"image/".$image->url."\" />";
}
echo "<h1>".rz_setting::get("site_title")."</h1>";
echo $bookEnd;
$htmlContent = ob_get_clean();

$html = new Epub_Element_Html();
$html->setContent($htmlContent);
$html->setFile('0.html');
$book->setCover($html);
$chapter = new Epub_Chapter();
$chapter->setTitle(rz_setting::get("site_title"));
$chapter->setLink($html);
$book->addChapter($chapter);



/*
 * List nodes
 */
recursiveNode( 0, $book ); 

$bookURL = rz_core::getBaseFolder().'rz-temp/'.rz_node::rz_clean_name(rz_setting::get("site_title")).'.epub';
$bookURI = rz_core::getBaseFolder(true).'rz-temp/'.rz_node::rz_clean_name(rz_setting::get("site_title")).'.epub';


$book->create($bookURI);

header("Content-type: application/epub+zip");
header("Location: ".$bookURL);

function recursiveNode( $parent_node_id, &$book)
{
	// ePub uses XHTML 1.1, preferably strict.
	$content_start =
	  "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
	. "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n"
	. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\">\n"
	. "<head>"
	. "<meta http-equiv=\"Content-Type\" content=\"application/xhtml+xml; charset=utf-8\" />\n"
	. "<title>".rz_setting::get("site_title")."</title>\n"
	//. "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />\n"
	. "</head>\n"
	. "<body>\n";

	$bookEnd = "</body>\n</html>";

 	$menu_entries = rz_node::get_rows(array(
 		"parent_node_id"=>$parent_node_id, 
 		"visible"=>1, 
 		"order_by"=>"order"
 	));

	while ($menu_entry = rz_node::hydrate($menu_entries)) 
	{
		$type = $menu_entry->get_node_type();

		$content = Markdown($menu_entry->content);
		$content = str_ireplace("./documents/", rz_core::getBaseFolder().'documents/', $content);


		/*
		 * Prepare images
		 */
		$imagesFound = array();
		preg_match_all('#'.preg_quote(rz_core::getBaseFolder().'documents/').'([^"]+)#i', $content, $imagesFound);

		//print_r($imagesFound);
		if (isset($imagesFound[1])) {
			foreach ($imagesFound[1] as $key => $imageSrc) {
				//echo $imageSrc."<br/>";
				$image = new Epub_Element_Image();
				$image->setSrc(rz_core::getBaseFolder(true).'documents/'.$imageSrc);
				$image->setFile('image/'.$imageSrc);
				$book->addImage($image);
			}
		}
		$content = preg_replace('#'.preg_quote(rz_core::getBaseFolder().'documents/').'([^"^\']+)#i', 'image/$1', $content);
		
		//echo htmlentities($content)."<br/><br/>";

		/*
		 * Prepare images
		 */
		ob_start();

		echo $content_start;
		?><h1 id="page_title"><?php echo $menu_entry->title ?></h1>
		<div class="content"><?php echo $content ?></div><?php
		echo $bookEnd;

		$htmlContent = ob_get_clean();

		//echo htmlentities($htmlContent)."<br/><br/>";

		$html = new Epub_Element_Html();
		$html->setContent($htmlContent);
		$html->setFile($menu_entry->node_name.".html");
		$book->addHtml($html);
		
		$chapter = new Epub_Chapter();
		$chapter->setTitle($menu_entry->title);
		$chapter->setLink($html);
		$book->addChapter($chapter);
		
		if ($menu_entry->has_children()) 
		{
			recursiveNode( $menu_entry->node_id, $book, $chapter);
		}
	}
} 
?>