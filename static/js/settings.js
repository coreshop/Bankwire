/**
 * Bankwire
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

pimcore.registerNS("pimcore.plugin.bankwire.settings");
pimcore.plugin.bankwire.settings = Class.create({

    initialize: function () {
        this.getData();
    },

    getData: function () {
        Ext.Ajax.request({
            url: "/plugin/Bankwire/admin/get",
            success: function (response)
            {
                this.data = Ext.decode(response.responseText);

                this.getTabPanel();

            }.bind(this)
        });
    },

    getValue: function (key) {
        var current = null;

        if(this.data.values.hasOwnProperty(key)) {
            current = this.data.values[key];
        }

        if (typeof current != "object" && typeof current != "array" && typeof current != "function") {
            return current;
        }

        return "";
    },

    getTabPanel: function () {

        if (!this.panel) {
            this.panel = Ext.create('Ext.panel.Panel', {
                id: "coreshop_bankwire",
                title: t("coreshop_bankwire"),
                iconCls: "coreshop_icon_bankwire",
                border: false,
                layout: "fit",
                closable:true
            });

            var tabPanel = Ext.getCmp("pimcore_panel_tabs");
            tabPanel.add(this.panel);
            tabPanel.setActiveItem("coreshop_bankwire");


            this.panel.on("destroy", function () {
                pimcore.globalmanager.remove("coreshop_bankwire");
            }.bind(this));


            var langTabs = [];
            var me = this;

            Ext.each(pimcore.settings.websiteLanguages, function(lang) {
                var tab = {
                    title: pimcore.available_languages[lang],
                    iconCls: "pimcore_icon_language_" + lang.toLowerCase(),
                    layout: 'border',
                    items: [{
                        xtype: 'htmleditor',
                        value: me.getValue("BANKWIRE.TEXT." + lang.toUpperCase()),
                        name: "BANKWIRE.TEXT." + lang.toUpperCase(),
                        border: 'solid 1px #ccc',
                        region: 'center',
                        enableFont: false,
                        enableFontSize: false,
                        enableColors: false,
                        enableFormat: false
                    }]
                };

                langTabs.push( tab );
            });

            this.layout = Ext.create('Ext.form.Panel', {
                bodyStyle:'padding:20px 5px 20px 5px;',
                layout : 'border',
                buttons: [
                    {
                        text: "Save",
                        handler: this.save.bind(this),
                        iconCls: "pimcore_icon_apply"
                    }
                ],
                items: [
                    {
                        xtype: "tabpanel",
                        region : 'center',
                        activeTab: 0,
                        defaults: {
                            autoHeight:true,
                            bodyStyle:'padding:10px;'
                        },
                        items: langTabs
                    }
                ]
            });

            this.panel.add(this.layout);

            pimcore.layout.refresh();
        }

        return this.panel;
    },

    activate: function () {
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        tabPanel.activate("coreshop_bankwire");
    },

    save: function () {
        var values = this.layout.getForm().getFieldValues();

        Ext.Ajax.request({
            url: "/plugin/Bankwire/admin/set",
            method: "post",
            params: {
                data: Ext.encode(values)
            },
            success: function (response) {
                try {
                    var res = Ext.decode(response.responseText);
                    if (res.success) {
                        pimcore.helpers.showNotification(t("success"), t("coreshop_bankwire_save_success"), "success");
                    } else {
                        pimcore.helpers.showNotification(t("error"), t("coreshop_bankwire_save_error"),
                            "error", t(res.message));
                    }
                } catch(e) {
                    pimcore.helpers.showNotification(t("error"), t("coreshop_bankwire_save_error"), "error");
                }
            }
        });
    }
});