Overview of system related internals used or defined by the extension 'staticpub_pageexport'
------------------------------------------------------------------------------------------------------------------------

1) What does this extension provides?
	With this extension, you can export a TYPO3-page as a ZIP-file. The extension internally use the staticpub- and crawler-extension, to do this.


2) How to configure this extension?
	1. Install this extension

	2. Create a staticpub-configuration. Either you add e.g. this TypoScript to your page-TypoSript:
		tx_staticpub_publish {
			includeResources=true
			overruleBaseUrl=
			publishDirForResources=typo3temp/staticpubresources/
		}
		tx_crawler >
		tx_crawler.crawlerCfg.paramSets {
			staticpub = 
			staticpub.procInstrFilter = tx_staticpub_publish
			staticpub.procInstrParams.tx_staticpub_publish < tx_staticpub_publish
		} 

	OR you create a "Crawler Configuration"-record with:
		- this "Processing instruction filter":
			Publish static [tx_staticpub_publish]

		- this "Processing instruction parameters":
			tx_staticpub_publish.includeResources=true
			tx_staticpub_publish.overruleBaseUrl=
			tx_staticpub_publish.publishDirForResources=typo3temp/staticpubresources/

	3. Go into the 'Functions'-Backend-Module (in your TYPO3-Backend).
	4. Select the 'Page-Export'-Function (you find the selection in the upper left corner in the content-frame)
	5. Select the page, which you want to export as a ZIP-file
	6. Click on the button "Start Export"
	
	
This extension is no longer actively maintained.
