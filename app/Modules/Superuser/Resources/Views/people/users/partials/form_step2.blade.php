<form method="POST" action="{{ route('addUserStep', ['step' => 3]) }}">
    <div class="form-group">
        <div class="radio">
            <label>
                <input type="radio" name="divisionOption" id="provinceDivision" value="province" checked="">
                Province
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="divisionOption" id="cityDivision" value="city">
                City
            </label>
        </div>
    </div>
</form>