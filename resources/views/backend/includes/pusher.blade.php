@php
$auth = auth('web')->user();
@endphp
<script>
     function fetch_my_notification() {
          let url = "{{ route('notification.my') }}"
          fetch(url, {
                    method: "GET"
               })
               .then(response => response.json())
               .then(response => {
                    let notification_list = document.getElementById("notification-list");
                    let notification_count = document.getElementById("notification_count")

                    // Clear existing notifications
                    notification_list.innerHTML = '';
                    notification_count.innerHTML = response.data.length

                    // Check if there are notifications
                    if (response.data && response.data.length > 0) {
                         // Loop through each notification in the response
                         response.data.forEach(notification => {
                              // Create a new list item
                              let listItem = document.createElement('li');
                              listItem.setAttribute('onclick', `handleNotificationClick('${notification.id}', this)`); // Adjust the id as needed
                              listItem.textContent = notification.message; // Adjust this to match the actual property of your notification object
                              notification_list.appendChild(listItem);
                         });
                    } else {
                         // If no notifications, show the message
                         let noNotificationItem = document.createElement('li');
                         noNotificationItem.textContent = "No notification found";
                         notification_list.appendChild(noNotificationItem);
                    }
               })
               .catch(response => {
                    console.log(response)
               })
     }

     function handleNotificationClick(id, e){
          let url = "{{ route('notification.make.view',':id') }}"
          url = url.replace(':id',id)
          fetch(url, {
                    method: "GET"
               })
               .then(response => response.json())
               .then(response => {
                    if(response.status == "success"){
                         if(e.dataset.icon){
                              e.classList.remove('fa-eye');
                              e.classList.add('fa-eye-slash');
                              e.removeAttribute('onclick');
                         }
                         fetch_my_notification()
                    }
               })
               .catch(response => {
                    console.log(response)
               })
     }
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
     const auth_id = "{{$auth->id}}";

     // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;

     var pusher = new Pusher('b34d3e28d4bac1e13363', {
          cluster: 'ap2'
     });

     var channel = pusher.subscribe(`notification-${auth_id}`);
     channel.bind('my-event', function(data) {
          fetch_my_notification();
     });
     fetch_my_notification();
</script>