<script>
     function sync_priority_report() {
          spinner.removeAttribute('hidden');
          const task_counting_route = "{{ route('dashboard.priority.report') }}"
          fetch(task_counting_route)
               .then(response => response.json())
               .then(response => {
                    if(response.status == "success"){
                         document.getElementById("low").innerHTML = response.data.low
                         document.getElementById("medium").innerHTML = response.data.medium
                         document.getElementById("high").innerHTML = response.data.high
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
     sync_priority_report();
</script>