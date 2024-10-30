<div class="card h-100">
     <div class="card-header">
          <div class="row">
               <div class="col-md-10">
                    <p>Status Report (last 30 days)</p>
               </div>
               <div class="col-md-2 text-right">
                    <button class="btn btn-sm d-inline" type="button" onclick="sync_status_report()">
                         <i class="fas fa-sync"></i>
                    </button>
               </div>
          </div>
     </div>
     <div class="card-body">
          <div class="row">

               <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-2">
                    <div class="card card-total" style="background: #D65DB1">
                         <div class="card-body">
                              <h5>Open</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="open_complaint" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-2">
                    <div class="card card-total" style="background: #A0A7B8">
                         <div class="card-body">
                              <h5>In Progress</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="in_progress_complaint" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-2">
                    <div class="card card-total" style="background: #A4E05D;">
                         <div class="card-body">
                              <h5>Resolved</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="resolved_complaint" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-2">
                    <div class="card card-total" style="background: #FEF3C7;">
                         <div class="card-body">
                              <h5>Closed</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="closed_complaint" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>
</div>