<div class="card h-100">
     <div class="card-header">
          <div class="row">
               <div class="col-md-10">
                    <p>Priority Report (last 30 days)</p>
               </div>
               <div class="col-md-2 text-right">
                    <button class="btn btn-sm d-inline" type="button" onclick="sync_priority_report()">
                         <i class="fas fa-sync"></i>
                    </button>
               </div>
          </div>
     </div>
     <div class="card-body">
          <div class="row">

               <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-2">
                    <div class="card card-total" style="background: #00B5B5">
                         <div class="card-body">
                              <h5>Low</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="low" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-2">
                    <div class="card card-total" style="background: #5AC8FA">
                         <div class="card-body">
                              <h5>Medium</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="medium" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-2">
                    <div class="card card-total" style="background: #8A56AC;">
                         <div class="card-body">
                              <h5>High</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="high" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>
</div>