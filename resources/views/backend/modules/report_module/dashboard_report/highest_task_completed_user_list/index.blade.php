<div class="card h-100">
     <div class="card-header">
          <div class="row">
               <div class="col-md-10">
                    <p>Highest task completed user list (Last 30 Days)</p>
               </div>
               <div class="col-md-2 text-right">
                    <button class="btn btn-sm d-inline" type="button" onclick="sync_highest_task_complete_user_list()">
                         <i class="fas fa-sync"></i>
                    </button>
               </div>
          </div>

     </div>
     <div class="card-body">
          <table class="table table-striped">
               <thead>
                    <tr>
                         <th scope="col">#</th>
                         <th scope="col">Name</th>
                         <th scope="col">Email</th>
                         <th scope="col">Task Complete</th>
                    </tr>
               </thead>
               <tbody id="highest_task_complete_user_list_table">
                    <tr>
                         <th colspan="4" class="text-center">No data found</th>
                    </tr>
               </tbody>
          </table>
     </div>
</div>