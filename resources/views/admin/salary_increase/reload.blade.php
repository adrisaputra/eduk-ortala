<li id="salary_increase" @if(in_array(Request::segment(1), array('parent_unit_salary_increase','salary_increase'))) class="active" @endif>
    <a href="@if(Auth::user()->group_id == 1) {{ url('parent_unit_salary_increase') }} @else {{ url('salary_increase') }} @endif"> KGB <span class="badge badge-danger" style="margin-top:-2px">1</span></a>
</li>