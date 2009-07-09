=== TopList.cz ===
Contributors: honza.skypala
Donate link: http://www.honza.info/
Tags: toplist, toplist.cz, web, pages, analytics, statistics, widget
Requires at least: 2.8
Tested up to: 2.8
Stable tag: 3.0

TopList.cz is a popular web analytics/statistics service in Czech Republic. This plugin is for easy integration of your WordPress blog into this service.


== Description ==

For English, see below.

Czech: Tento plug-in Vám zajistí snadné použití statistické služby TopList.cz ve vašem blogu provozovaném na systému WordPress. Plug-in přidá nový widget (nazvaný TopList.cz) a jeho umístěním na stránku (do sidebaru) zajistíte automatické používání služby. Autoři webových stránek běžně zařazují kód pro používání služby TopList.cz do šablony vzhledu - ovšem moje řešení pomocí pluginu/widgetu zajistí používání služby bez ohledu na použitou šablonu - můžete šablony vzhledu přepínat dle libosti a statistiky jsou stále zajištěny. K dispozici je plná konfigurace služby (např. vzhled ikony, detaily sledování apod.).

Související odkazy:

* <a href="http://www.honza.info/category/wordpress/" title="Kategorie počítače na mých stránkách">Plugin Homepage</a>
* <a href="http://www.honza/info/" title="honza.info">Moje webové stránky</a>
* <a href="http://www.toplist.cz/" title="TopList.cz">Server TopList.cz</a>

English: This plug-in allows for easy integration of web statistics service TopList.cz into your blog run by WordPress. Plug-in adds a new widget (called TopList.cz) to WordPress and by placing the widget on your page (sidebar) you integrate TopList.cz into your blog. It is common to put the code for such service into the theme template, but my solution utilizing it as a widget allows to run the statistics regardless of the theme used - you can switch the themes and it works all the time. The widget contains complete configuration (displayed icon, detailed analytics etc.).

Related Links:

* <a href="http://www.honza.info/category/wordpress/" title="Computer related stuff on honza.info">Plugin Homepage</a>
* <a href="http://www.honza/info/" title="Author's homepage">Autor's homepage</a>
* <a href="http://www.toplist.cz/" title="TopList.cz">Web interface of TopList.cz server</a>


== Installation ==

For English, see below.

Czech:

1.	Pokud ještě nemáte svou registraci na serveru toplist.cz, pak je zapotřebí se <a href="http://www.toplist.cz/edit/?a=e" target="_blank">zaregistrovat</a> a získat ID pro své webové stránky.
2.	Nahrajte kompletní adresář pluginu do wp-content/plugins.
3.	Aktivujte plugin TopList.cz v administraci plug-inů.
4.	Přidejte widget TopList.cz v administraci Vzhled->Widgety.
5.	V konfiguraci widgetu zadejte své ID pro server toplist.cz, případně zvolte další volby. Uložte změny.
6.	Plugin zajistí zobrazení ikony TopListu, ale (záměrně) nezajistí jeho formátování (zarovnání vlevo/vpravo, případně vycentrování).  Pokud chcete mít obrázek v sidebaru vycentrovaný, přidejte do své šablony vzhledu - do souboru CSS s kaskádovým stylem: .widget_toplist_cz {text-align:center}
7.	Pokud chcete službu používat, ale nechcete widget vůbec zobrazovat (i když zvolíte neviditelnou ikonu, stále si widget na stránce vezme určité místo), přidejte do své šablony vzhledu - do souboru CSS s kaskádovým stylem: .widget_toplist_cz {display:none}

English:

1.	If you don't have a toplist.cz server registration yet, you have to <a href="http://www.toplist.cz/edit/?a=e" target="_blank">registrate</a> and receive ID number for your web presentation.
2.	Upload the full plugin directory into your wp-content/plugins directory.
3.	Activate the plugin in plugins administration.
4.	Add widget TopList.cz into your sidebar in Widgets administration.
5.	In widget configuration, enter your ID number for toplist.cz server; eventually you can change other options. Save changes.
6.	Plugin displays the TopList icon on your blog, but it does not do any formatting (like align to top/right or center). This is on purpose, formatting should be provided by the presentation layer, which is a used theme. To center the icon, add to your theme, to the CSS style file: .widget_toplist_cz {text-align:center}
7.	If you do want to use the service, but don't want to display the widget (even when you select the invisible icon, it still takes part of your sidebar), add to your theme, to the CSS style file: .widget_toplist_cz {display:none}


== Screenshots ==

1. Konfigurace widgetu / widget configuration


== Changelog ==

= 3.0 =
* Recoded for WordPress 2.8 API.

= 2.0 =
* Added support for toplist.sk server.
* Link can lead to detailed statistics now.

= 1.0 =
* Initial release.


== Licence ==

GNU General Public License version 2 applies
