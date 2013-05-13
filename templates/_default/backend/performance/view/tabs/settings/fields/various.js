/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Customer
 * @subpackage Detail
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author shopware AG
 */

//{namespace name=backend/performance/main}

/**
 * Categories fieldSet
 */
//{block name="backend/performance/view/tabs/settings/fields/various"}
Ext.define('Shopware.apps.Performance.view.tabs.settings.fields.Various', {
    /**
     * Define that the base field set is an extension of the "Base" fieldSet
     * @string
     */
    extend:'Shopware.apps.Performance.view.tabs.settings.fields.Base',

    /**
     * List of short aliases for class names. Most useful for defining xtypes for widgets.
     * @string
     */
    alias:'widget.performance-tabs-settings-various',

    /**
     * Description of the fieldSet
     */
    caption: '{s name=tabs/settings/various/title}Various{/s}',

    /**
     * Component event method which is fired when the component
     * is initials. The component is initials when the user
     * want to create a new customer or edit an existing customer
     * @return void
     */
    initComponent:function () {
        var me = this;

        me.items = me.getItems();
        me.callParent(arguments);

    },

    getItems: function() {
        var me = this;

        return [
            {
                xtype: 'fieldset',
                title: 'Information',
                defaults: me.defaults,
                items: [
                    me.createDecriptionContainer("Allgemeine Beschreibung für verschiedene kleinere Einstellungen <br>" +
                            "<br>" +
                            "<b>Wichtig: </b> Informationen")]
            },
            {
                xtype: 'fieldset',
                title: 'Konfiguration',
                defaults: me.defaults,
                items: [
                    {
                        fieldLabel: 'Shopware Statistiken deaktivieren',
                        helpText: 'Keine Statistiken erheben',
                        name: 'various[disableShopwareStatistics]',
                        xtype: 'checkbox',
                        uncheckedValue: false,
                        inputValue: true
                    },
                    {
                        fieldLabel: 'Tag-Cloud aktivieren',
                        helpText: 'Soll eine TagCloud angezeigt werden?',
                        name: 'various[TagCloud:show]',
                        xtype: 'checkbox',
                        uncheckedValue: false,
                        inputValue: true
                    },
                    {
                        fieldLabel: 'Artikelverlauf anzeigen',
                        name: 'various[LastArticles:show]',
                        xtype: 'checkbox',
                        uncheckedValue: false,
                        inputValue: true
                    },
                    {
                        fieldLabel: 'Anzahl Artikel im Verlauf',
                        helpText: 'Anzahl der Artikel im Widget "zuletzt angesehene Artikel"',
                        name: 'various[LastArticles:lastarticlestoshow]',
                        xtype: 'numberfield',
                        minValue: 1
                    },
                    {
                        fieldLabel: 'Artikelnavigation auf Detailseite deaktivieren',
                        helpText: 'Deaktiviert die links/rechts-Pfeile auf der Artikel-Detailseite',
                        name: 'various[disableArticleNavigation]',
                        xtype: 'checkbox',
                        uncheckedValue: false,
                        inputValue: true
                    }
                ]}
        ];
    }


});
//{/block}
