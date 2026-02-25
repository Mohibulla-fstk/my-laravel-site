div class="filerSliderItem">

    <div class="filterSecName">
        <div class="hero-section"><i class="fa-solid fa-bars-filter"></i> Filter</div>
                    <div class="filter-close"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                   <div class="hero-2part">
                     <form id="filterForm" class="attribute-submit" action="{{ url()->current() }}" method="GET">
    <!-- Checkbox, price inputs etc -->
                        <div class="sidebar_item wraper__item">
                            <div class="accordion" id="category_sidebar">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCat" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $category->name }}
                                        </button>
                                    </h2>
                                    <div id="collapseCat" class="accordion-collapse collapse show"
                                        data-bs-parent="#category_sidebar">
                                        <div class="accordion-body cust_according_body">
                                            <ul>
                                                @foreach ($category->subcategories as $key => $subcat)
                                                    <li>
                                                        <a
                                                            href="{{ url('subcategory/' . $subcat->slug) }}">{{ $subcat->subcategoryName }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--sidebar item end-->
                        <div class="sidebar_item wraper__item">
                            <div class="accordion" id="price_sidebar">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePrice" aria-expanded="true" aria-controls="collapseOne">
                                            Price
                                        </button>
                                    </h2>
                                    <div id="collapsePrice" class="accordion-collapse collapse show"
                                        data-bs-parent="#price_sidebar">
                                        <div class="accordion-body cust_according_body">
                                            <div class="category-filter-box category__wraper" id="categoryFilterBox">
                                                <div class="category-filter-item">
                                                    <div class="filter-body">
                                                        <div class="slider-box">
                                                            <div class="filter-price-inputs">
                                                                <p class="min-price">৳<br><input type="text"
                                                                        name="min_price" id="min_price" />
                                                                </p>
                                                                <p class="max-price">৳<input type="text"
                                                                        name="max_price" id="max_price" />
                                                                </p>
                                                            </div>
                                                            <div id="price-range" class="slider form-attribute"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--sidebar item end-->
                        <div class="sidebar_item wraper__item">
                            <div class="accordion" id="filter_sidebar">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFilter" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Filter
                                        </button>
                                    </h2>
                                    <div id="collapseFilter" class="accordion-collapse collapse show"
                                        data-bs-parent="#filter_sidebar">
                                        <div class="accordion-body cust_according_body">
                                            <div class="filter-body">
                                                <ul class="space-y-3">
                                                    @foreach ($subcategories as $subcategory)
                                                        <li class="subcategory-filter-list">
                                                            <label for="{{ $subcategory->slug . '-' . $subcategory->id }}"
                                                                class="subcategory-filter-label">
                                                                <input class="form-checkbox form-attribute"
                                                                    id="{{ $subcategory->slug . '-' . $subcategory->id }}"
                                                                    name="subcategory[]" value="{{ $subcategory->id }}"
                                                                    type="checkbox"
                                                                    @if (is_array(request()->get('subcategory')) && in_array($subcategory->id, request()->get('subcategory'))) checked @endif />
                                                                <p class="subcategory-filter-name">
                                                                    {{ $subcategory->subcategoryName }}</p>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
          <div class="sidebar_item wraper__item">
    <div class="accordion" id="filter_sidebar">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseOne">
                    Stock
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse show"
                data-bs-parent="#filter_sidebar">
                <div class="accordion-body cust_according_body">
                    <div class="filter-body">
                        <ul class="space-y-3">
                            <li>
                                <label>
                                    <input type="checkbox" name="stock[]" value="In Stock"
                                        class="form-checkbox form-attribute"
                                        @if(is_array(request()->get('stock')) && in_array('In Stock', request()->get('stock'))) checked @endif>
                                    In Stock
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="stock[]" value="Stock out"
                                        class="form-checkbox form-attribute"
                                        @if(is_array(request()->get('stock')) && in_array('Out of Stock', request()->get('stock'))) checked @endif>
                                    Out of Stock
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  </form> 
                   </div>


                        <!--sidebar item end-->
                    
                    
    </div>