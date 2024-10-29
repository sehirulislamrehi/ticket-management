<script>
     function sync_highest_task_complete_user_list() {
          spinner.removeAttribute('hidden');
          const highest_complete_task_user_route = "{{ route('dashboard.report.highest.complete.task.user') }}"
          fetch(highest_complete_task_user_route)
               .then(response => response.json())
               .then(response => {
                    if (response.status == "success") {
                         let highest_task_complete_user_list_table = document.getElementById("highest_task_complete_user_list_table")
                         highest_task_complete_user_list_table.innerHTML = '';

                         if (response.data.length > 0) {
                              response.data.forEach((user, key) => {
                                   // Create a new table row (tr)
                                   let tr = document.createElement('tr');

                                   // Append new table cells (td) for each column
                                   tr.innerHTML = `
                    <td>${key + 1}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.completed_tasks}</td>
                `;

                                   // Append the row to the table body
                                   highest_task_complete_user_list_table.appendChild(tr);
                              });
                         } else {
                              let noDataTr = document.createElement('tr');
                              noDataTr.innerHTML = `
                <th colspan="4" class="text-center">No data found</th>
            `;
                              highest_task_complete_user_list_table.appendChild(noDataTr);
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
     sync_highest_task_complete_user_list();
</script>