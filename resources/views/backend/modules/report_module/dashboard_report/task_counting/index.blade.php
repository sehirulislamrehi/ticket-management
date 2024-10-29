<div class="card h-100">
     <div class="card-header">
          <div class="row">
               <div class="col-md-10">
                    <p>Task Counting</p>
               </div>
               <div class="col-md-2 text-right">
                    <button class="btn btn-sm d-inline" type="button" onclick="sync_task_counting()">
                         <i class="fas fa-sync"></i>
                    </button>
               </div>
          </div>
     </div>
     <div class="card-body">
          <div class="row">

               <div class="col-md-3 col-6">
                    <div class="card card-total" style="background: #f8ff97">
                         <div class="card-body">
                              <h5>Yesterday Created</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="yesterday_task" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-md-3 col-6">
                    <div class="card card-total" style="background: #8fffb2">
                         <div class="card-body">
                              <h5>Yesterday Complete</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="yesterday_complete" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-md-3 col-6">
                    <div class="card card-total" style="background: #bce1fd;">
                         <div class="card-body">
                              <h5>Last 30 Days Task</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="total_task" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-md-3 col-6">
                    <div class="card card-total" style="background: #ffbed3;">
                         <div class="card-body">
                              <h5>Avg Task Time (H:M) Last 30 Days</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="average_task_time" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>
</div>