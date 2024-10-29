<script>
     function sync_highest_average_time_taken_user() {
          spinner.removeAttribute('hidden');
          const task_counting_route = "{{ route('dashboard.report.highest.average.time.taken.user') }}"
          fetch(task_counting_route)
               .then(response => response.json())
               .then(response => {
                    if (response.status == "success") {
                         let highest_average_time_taken_user_table = document.getElementById("highest_average_time_taken_user_table")
                         highest_average_time_taken_user_table.innerHTML = '';

                         if (response.data.length > 0) {
                              response.data.forEach((user, key) => {
                                   // Create a new table row (tr)
                                   let tr = document.createElement('tr');

                                   // Append new table cells (td) for each column
                                   tr.innerHTML = `
                    <td>${key + 1}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.hour_min}</td>
                `;

                                   // Append the row to the table body
                                   highest_average_time_taken_user_table.appendChild(tr);
                              });
                         } else {
                              let noDataTr = document.createElement('tr');
                              noDataTr.innerHTML = `
                <th colspan="4" class="text-center">No data found</th>
            `;
                              highest_average_time_taken_user_table.appendChild(noDataTr);
                         }
                    } else {
                         console.log(response)
                    }
                    spinner.setAttribute('hidden', '');
               })
               .catch(response => {
                    console.log(response)
                    spinner.setAttribute('hidden', '');
               })
     }
     sync_highest_average_time_taken_user();
</script>