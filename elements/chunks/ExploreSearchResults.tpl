  <div class="row explore">
    <div class="large-12 columns" id="filter_flyout">
      <div class="row">
        <div class="small-centered large-12 columns">
          <ul class="filter-block">
            <li><p style="color:#37BDD6">[[+hit_count]] Results </p></li>
            <li><p style="color:#37BDD6">Filter by</p></li>
            <!--<li>
              <a href="#" data-dropdown="start-time" class="button secondary filter dropdown">Communities</a><br>
              <ul id="start-time" data-dropdown-content class="f-dropdown">
                <li><a href="#">Central</a></li>
                <li><a href="#">North</a></li>
                <li><a href="#">Northeast</a></li>
                <li><a href="#">South</a></li>
                <li><a href="#">Southeast</a></li>
                <li><a href="#">West</a></li>
              </ul>
            </li>-->
            <li>
              <a href="#" data-dropdown="price_options" class="button secondary dropdown" style="background-color:#FFF">Price</a><br>
              <ul id="price_options" data-dropdown-content class="f-dropdown">
                <li><a href="#" class="filter" data-filter-type="price" data-filter-value="free">Free</a></li>
                <li><a href="#" class="filter" data-filter-type="price" data-filter-value="paid">Paid</a></li>
              </ul>
            </li>
            <li>
              <a href="#" data-dropdown="age" class="button secondary dropdown" style="background-color:#FFF">Age</a><br>
              <ul id="age" data-dropdown-content class="f-dropdown">
                <li><a href="#" class="filter" data-filter-type="age_range" data-filter-value="2-5">2-5</a></li>
                <li><a href="#" class="filter" data-filter-type="age_range" data-filter-value="5-8">5-8</a></li>
                <li><a href="#" class="filter" data-filter-type="age_range" data-filter-value="8-12">8-12</a></li>
                <li><a href="#" class="filter" data-filter-type="age_range" data-filter-value="12-16">12-16</a></li>
                <li><a href="#" class="filter" data-filter-type="age_range" data-filter-value="16-19">16-19</a></li>
                <li><a href="#" class="filter" data-filter-type="age_range" data-filter-value="19-22">19-22</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="large-12 column">
      <div class="row" style="background-color: #E9E9E9;margin-left:0;margin-right:0">
        <div class="small-10 large-10 large-offset-1 columns end">
          <div class="items">
            <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
            [[+search_result_items]]                           
            </ul>
          </div>
        </div>
      </div>
    </div>
    [[+paging]]
</div>
