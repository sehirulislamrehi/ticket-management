<script>
     function sync_category_report() {
          spinner.removeAttribute('hidden');
          const task_counting_route = "{{ route('dashboard.category.report') }}"
          fetch(task_counting_route)
               .then(response => response.json())
               .then(response => {
                    if(response.status == "success"){
                         document.getElementById("billing").innerHTML = response.data.billing
                         document.getElementById("service_issue").innerHTML = response.data.service_issue
                         document.getElementById("product_issue").innerHTML = response.data.product_issue
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
     sync_category_report();
</script>