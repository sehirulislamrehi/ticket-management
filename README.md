
## Project installation guide
     - Run composer update to install the dependencies
     - Run migrate and seed command.
     - You can update the user seeder data with your suitable credentials to test. Demo compalint data will create based on user id 1 to 4.
     - The api are given as postman collection in the root directory with the name of "Auth.postman_collection.json" and "Complaint.postman_collection.json". Import it to the postman to use the api.

## User Module
     - There is a super admin account. Using that account no restriction will be shown.
     - User assigned with a specific role.
     - There is a customized permission system which is assigned with role.
     - User can update his/her profile information and change update.

## Complaint Module
     - User can create complaint and get real-time notification into the notification bar.
     - User can update the see and update only his/her complaint and also get notified.
     - Super admin can see all complaint and add comment agaisnt complaint.
     - You can search compalint using the filter options.

## Notification Module
     - User can see his/her notifications.
     - View and not viewed notification will separately identified.
     - User can delete his/her notification.
     - Pusher credentials already set into the PusherService.

