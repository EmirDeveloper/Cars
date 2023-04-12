<form action="{{ url()->current() }}" method="get">
    <div class="accordion" id="accordionPanelsStayOpenExample">

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading-c">
                <button class="accordion-button bg-color-b" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-c" aria-expanded="true" aria-controls="panelsStayOpen-collapse-c">
                    @lang('app.categories')
                </button>
            </h2>
            <div id="panelsStayOpen-collapse-c" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading-c">
                <div class="accordion-body px-2 py-1">
                    @foreach($category as $c)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="flexCheck-c-{{ $category->id }}" name="c[]"
                                   value="{{ $category->id }}" {{ $category->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheck-c-{{ $category->id }}">{{ $category->getName() }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        
    </div>
</form>