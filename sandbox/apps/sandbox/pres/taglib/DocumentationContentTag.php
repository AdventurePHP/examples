<?php
import('tools::request', 'RequestHandler');

class DocumentationContentTag extends Document {

   public function onAfterAppend() {

      $id = RequestHandler::getValue('id', '013');

      $files = glob(APPS__PATH . '/sandbox/pres/content/c_' . $this->getLanguage() . '_' . $id . '_*');
      if (count($files) > 0) {
         $this->setContent($this->sanitizeContent(file_get_contents($files[0])));
      }

   }

   private function sanitizeContent($content) {
      $onlineDocAnchorName = $this->getLanguage() == 'de'
            ? 'Online-Dokumentation'
            : 'Online documentation';

      // rewrite images to the current installation
      $content = preg_replace('/src="http:\/\/media.adventure-php-framework.org\/content\/(.+)"/isU', 'src="images/$1"', $content);
      $content = preg_replace('/<int:link pageid="([0-9]+)"(.+)?>(.+)<\/int:link>/iU', '<a href="http://adventure-php-framework.org/Seite/119-Komponenten-Dokumentation">[' . $onlineDocAnchorName . ']</a>', $content);
      $content = preg_replace('/<int:link pageid="([0-9]+)"(.+)?\/>/iU', '<a href="http://adventure-php-framework.org/Seite/119-Komponenten-Dokumentation">[' . $onlineDocAnchorName . ']</a>', $content);
      $content = preg_replace('/<doku:link>(.+)<\/doku:link>/isU', '<a href="$1">$1</a>', $content);
      $content = preg_replace('/<core:importdesign namespace="modules::comments::pres::templates" template="comment" categorykey="(.+)" \/>/isU', '', $content);
      $content = preg_replace('/<gen:highlight type="([a-z\-]+)">(.+)<\/gen:highlight>/isU', '<pre>$2</pre>', $content);
      return preg_replace('/<doku:title (.+) title="(.+)" (.+)>(.+)<\/doku:title>/isU', '<h2>$2</h2>', $content);
   }

}
