<div class="card h-100">
     <div class="card-header">
          <div class="row">
               <div class="col-md-10">
                    <p>Category Report (last 30 days)</p>
               </div>
               <div class="col-md-2 text-right">
                    <button class="btn btn-sm d-inline" type="button" onclick="sync_category_report()">
                         <i class="fas fa-sync"></i>
                    </button>
               </div>
          </div>
     </div>
     <div class="card-body">
          <div class="row">

               <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-2">
                    <div class="card card-total" style="background: #FFD700">
                         <div class="card-body">
                              <h5>Billing</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="billing" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-2">
                    <div class="card card-total" style="background: #FF8C42">
                         <div class="card-body">
                              <h5>Service Issue</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="service_issue" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-2">
                    <div class="card card-total" style="background: #FF4C4C;">
                         <div class="card-body">
                              <h5>Product Issue</h5>
                              <div class="d-flex justify-content-between align-items-center">
                                   <div class="icon pr-1">
                                   <div id="product_issue" class="pl-0 calling-font">Loading...</div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     </div>
</div>