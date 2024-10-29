<script>
     function sync_task_counting() {
          spinner.removeAttribute('hidden');
          const task_counting_route = "{{ route('dashboard.report.task.counting') }}"
          fetch(task_counting_route)
               .then(response => response.json())
               .then(response => {
                    if(response.status == "success"){
                         let yesterday_task = document.getElementById("yesterday_task").innerHTML = response.data.yesterday_task
                         let yesterday_complete = document.getElementById("yesterday_complete").innerHTML = response.data.yesterday_complete
                         let total_task = document.getElementById("total_task").innerHTML = response.data.total_task_last_thirty_days
                         let average_task_time = document.getElementById("average_task_time").innerHTML = response.data.average_time_taken_second
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
     sync_task_counting();
</script>