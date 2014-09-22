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

##Installing MongoDB
Follow the [installation instructions](http://docs.mongodb.org/manual/installation/) for your operating system on the official MongoDB documentation website.

##Configuring MongoDB
1. Once you have MongoDB installed, crank up an instance by running ```mongod``` in your command line.
2. Open up a console to your mongod instance by running ```mongo``` in your command line.
3. Create an administrative user for Drupal. You can set permissions as you please. To add an administrative user for any database, run: ```db.createUser( { user: "drupal", pwd: "drupal", roles: [ { role: "userAdminAnyDatabase", db: "admin" } ] } )``` within your mongo console.
4. Use the user you created to connect to mongo from Drupal by adding the user credentials and connection details too the Mongosync settings. See above installation instructions.