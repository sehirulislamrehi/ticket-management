<script>
     function sync_status_report() {
          spinner.removeAttribute('hidden');
          const task_counting_route = "{{ route('dashboard.status.report') }}"
          fetch(task_counting_route)
               .then(response => response.json())
               .then(response => {
                    if(response.status == "success"){
                         document.getElementById("open_complaint").innerHTML = response.data.open
                         document.getElementById("in_progress_complaint").innerHTML = response.data.in_progress
                         document.getElementById("resolved_complaint").innerHTML = response.data.resolved
                         document.getElementById("closed_complaint").innerHTML = response.data.closed
                    }
                    else{
                         console.log(response)
                    }
                    spinner.setAttribute('hidden', '');
               })
               .catch(response => {
                    console.log(response)
                    spinner.setAttribute('hidden', '');
               })
     }
     sync_status_report();
</script>