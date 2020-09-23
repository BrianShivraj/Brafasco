/*********  STORES  ********/
insert into `{{table:inventory_source}}`(`source_code`,`name`,`enabled`,`description`,`latitude`,`longitude`,`country_id`,`region_id`,`region`,`city`,`street`,`postcode`,`contact_name`,`email`,`phone`,`fax`,`use_default_carrier_config`) values ('green_forest_store','Green Forest Store',1,'',48.869232,2.308834,'FR',257,null,'Paris','1 avenue des Champs-Elysée','75000','Green Forest Store Owner','greenforest@wyomind.com','123456789',null,1);
insert into `{{table:inventory_source}}`(`source_code`,`name`,`enabled`,`description`,`latitude`,`longitude`,`country_id`,`region_id`,`region`,`city`,`street`,`postcode`,`contact_name`,`email`,`phone`,`fax`,`use_default_carrier_config`) values ('long_road_store','Long Road Store',1,'',51.507916,-0.087677,'GB',null,null,'London','1, London Bridge','EC3R 6HD','Long Road Store Owner','longroad@wyomind.com','123456789',null,1);
insert into `{{table:inventory_source}}`(`source_code`,`name`,`enabled`,`description`,`latitude`,`longitude`,`country_id`,`region_id`,`region`,`city`,`street`,`postcode`,`contact_name`,`email`,`phone`,`fax`,`use_default_carrier_config`) values ('great_lake_store','Great Lake Store',1,null,40.787109,-73.966329,'US',43,null,'New York','101, Shuman Running Track','1023','Great Lake Store Owner','greatlake@wyomind.com','123456789',null,1);
insert into `{{table:inventory_source}}`(`source_code`,`name`,`enabled`,`description`,`latitude`,`longitude`,`country_id`,`region_id`,`region`,`city`,`street`,`postcode`,`contact_name`,`email`,`phone`,`fax`,`use_default_carrier_config`) values ('wild_desert_store','Wild Desert Store',1,null,22.130689,25.264348,'EG',null,null,'','Somewhere in the desert','','Wild Desert Store Owner','wilddesert@wyomind.com','123456789',null,1);
/*insert into `{{table:inventory_source_storelocator}}`(`source_code_orig`,`customer_group_ids`,`store_ids`,`display_order`,`street_additional`,`image`,`business_hours`,`days_off`,`page`,`use_config_description`,`visible_in_storelocator`,`enable_page`,`url_key`) values ('default',null,null,0,null,null,'{}',null,null,0,0,0,'');*/
insert into `{{table:inventory_source_storelocator}}`(`source_code_orig`,`customer_group_ids`,`store_ids`,`display_order`,`street_additional`,`image`,`business_hours`,`days_off`,`page`,`use_config_description`,`visible_in_storelocator`,`enable_page`,`url_key`) values ('long_road_store','0,1,2,3','0,1,2',1,null,'wysiwyg/collection/collection-performance.jpg','{"Monday":{"from":"10:00","to":"20:00"},"Tuesday":{"from":"10:00","to":"20:00"},"Wednesday":{"from":"10:00","to":"20:00"},"Thursday":{"from":"10:00","to":"20:00"},"Friday":{"from":"10:00","to":"20:00"},"Saturday":{"from":"00:00","to":"20:00"}}','2019-12-25\
2020-01-01','',1,1,1,'long-road-store');
insert into `{{table:inventory_source_storelocator}}`(`source_code_orig`,`customer_group_ids`,`store_ids`,`display_order`,`street_additional`,`image`,`business_hours`,`days_off`,`page`,`use_config_description`,`visible_in_storelocator`,`enable_page`,`url_key`) values ('green_forest_store','0,1,2,3','0,1,2',1,'second floor','wysiwyg/collection/collection-eco.jpg','{"Monday":{"from":"09:00","to":"19:00","lunch_from":"13:00","lunch_to":"14:00"},"Tuesday":{"from":"09:00","to":"19:00","lunch_from":"13:00","lunch_to":"14:00"},"Wednesday":{"from":"09:00","to":"19:00","lunch_from":"14:00","lunch_to":"14:00"},"Thursday":{"from":"09:00","to":"19:00","lunch_from":"13:00","lunch_to":"14:00"},"Friday":{"from":"19:00","to":"19:00","lunch_from":"13:00","lunch_to":"14:00"},"Saturday":{"from":"09:00","to":"19:00"}}','2019-12-24 16:30-19:00\
2019-12-25\
2020-01-01','',1,1,1,'green-forest-store');
insert into `{{table:inventory_source_storelocator}}`(`source_code_orig`,`customer_group_ids`,`store_ids`,`display_order`,`street_additional`,`image`,`business_hours`,`days_off`,`use_config_page`,`page`,`use_config_description`,`visible_in_storelocator`,`enable_page`,`url_key`) values ('great_lake_store','0,1,2,3','0,1,2',1,null,'stores/great-lake-store.jpg','{"Monday":{"from":"09:00","to":"20:00"},"Tuesday":{"from":"09:00","to":"20:00"},"Wednesday":{"from":"09:00","to":"20:00"},"Thursday":{"from":"09:00","to":"20:00"},"Friday":{"from":"09:00","to":"20:00"},"Saturday":{"from":"09:00","to":"20:00"},"Sunday":{"from":"09:00","to":"20:00"}}',null,1,null,1,1,1,'great-lake-store');
insert into `{{table:inventory_source_storelocator}}`(`source_code_orig`,`customer_group_ids`,`store_ids`,`display_order`,`street_additional`,`image`,`business_hours`,`days_off`,`use_config_page`,`page`,`use_config_description`,`visible_in_storelocator`,`enable_page`,`url_key`) values ('wild_desert_store','0,1,2,3','0,1,2',1,null,'stores/wild-desert-store.jpg','{"Monday":{"from":"09:00","to":"20:00"},"Tuesday":{"from":"09:00","to":"20:00"},"Wednesday":{"from":"09:00","to":"20:00"},"Thursday":{"from":"09:00","to":"20:00"},"Friday":{"from":"09:00","to":"20:00"},"Saturday":{"from":"09:00","to":"20:00"},"Sunday":{"from":"09:00","to":"20:00"}}',null,1,null,1,1,1,'wild-dessert-store');



/*************** ADDITIONNAL ATTRIBUTES *************/
insert into `{{table:storelocator_attributes}}`(`attribute_id`,`code`,`label`,`type`) values (1,'welcome_message','Store welcome message',1);
insert into `{{table:storelocator_attributes_values}}`(`value_id`,`attribute_id`,`source_code_orig`,`value`) values (NULL,1,'long_road_store','<p><strong>Visit us, we will be glad to meet you</strong>.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#">tempor incididunt</a> ut labore et dolore magna aliqua.</p>
<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident:</p>
<ul>
<li>sunt in culpa qui officia,</li>
<li>deserunt mollit anim id est laborum.</li>
</ul>'),(NULL,1,'green_forest_store','<p><strong>Visit us, we will be glad to meet you</strong>.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#">tempor incididunt</a> ut labore et dolore magna aliqua.</p>
<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident:</p>
<ul>
<li>sunt in culpa qui officia,</li>
<li>deserunt mollit anim id est laborum.</li>
</ul>'),(NULL,1,'great_lake_store','<p><strong>Visit us, we will be glad to meet you</strong>.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#">tempor incididunt</a> ut labore et dolore magna aliqua.</p>
<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident:</p>
<ul>
<li>sunt in culpa qui officia,</li>
<li>deserunt mollit anim id est laborum.</li>
</ul>'),(NULL,1,'wild_desert_store','<p><strong>Visit us, we will be glad to meet you</strong>.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#">tempor incididunt</a> ut labore et dolore magna aliqua.</p>
<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident:</p>
<ul>
<li>sunt in culpa qui officia,</li>
<li>deserunt mollit anim id est laborum.</li>
</ul>');



/*********  CONFIG DATA  ********/
insert into `{{table:core_config_data}}`(`config_id`,`scope`,`scope_id`,`path`,`value`) values (NULL,'default',0,'storelocator/settings/googleapi','AIzaSyDXgRKX3liCKyoxa5eKhP7eVCJvJ1Hg3pE');
/*********  WIDGET ********/
insert into `{{table:widget_instance}}`(`instance_id`,`instance_type`,`theme_id`,`title`,`store_ids`,`widget_parameters`,`sort_order`) values (NULL,'Wyomind\\StoreLocator\\Block\\Widget\\StoreLocator',3,'Store Locator','0',null,0);
SELECT @instance_id:=LAST_INSERT_ID();
insert into `{{table:widget_instance_page}}`(`page_id`,`instance_id`,`page_group`,`layout_handle`,`block_reference`,`page_for`,`entities`,`page_template`) values (NULL,@instance_id,'all_pages','default','header.panel','all','','');
SELECT @page_id:=LAST_INSERT_ID();
insert into `{{table:layout_update}}`(`layout_update_id`,`handle`,`xml`,`sort_order`,`updated_at`) values (NULL,'default','<body><referenceContainer name="header.panel"><block class="Wyomind\StoreLocator\Block\Widget\StoreLocator" name="mCzI9zIRy5UJvIbRCj6z4xsfBT1DWU94"></block></referenceContainer></body>',0,null);
SELECT @layout_id:=LAST_INSERT_ID();
insert into `{{table:widget_instance_page_layout}}`(`page_id`,`layout_update_id`) values (@page_id,@layout_id);
