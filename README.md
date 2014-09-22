#Mongosync

Mongo sync is a project that allows a Drupal instance to easily send entitys of a specified type and bundle to a configurable MongoDB collection.

##Installation
1. Install Mongosync: ```drush dl mongosync```.
2. Enable Mongosync: ```drush en -y mongosync```.
3. Navigate to Mongosync configuration page within Drupal by visiting http://mydrupalinstance.com/admin/config/mongosync
4. Add Mongo Server connection details in the "MongoDB Server" settings form. See MongoDB instructions below for information on how to install and set up MongoDB for use.
5. Open "Entity Sync Settings" and turn on "Sync *entity* of type *bundle*".
6. Enter a collection name that you would like *entity* of type *bundle* to be inserted into.
7. Save settings.
8. Insert an entity of the type and bundle you specified.
9. Verify that entities are being added to MongoDB collection.