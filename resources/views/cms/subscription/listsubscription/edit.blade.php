<form method="post" action="{{ route('list-subscription-update', $data->id) }}">
@csrf

    <div class="form-group ">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" value="{{$data->name}}" id="name">
    </div>
    <div class="form-group">
        <label for="plan_period">Plan Period</label>
            <select class="form-control " id="plan_period" name="plan_period">
                <option value="{{ \EnumSubscription::PLAN_DAILY }}">Harian</option>
                <option value="{{ \EnumSubscription::PLAN_WEEKLY }}">Mingguan</option>
                <option value="{{ \EnumSubscription::PLAN_MONTHLY }}">Bulanan</option>
                <option value="{{ \EnumSubscription::PLAN_YEARLY }}">Tahunan</option>
            </select>
    </div>
    <div class="form-group ">
    <label for="name">Price</label>
        <input class="form-control" name="price" type="text" placeholder="Required" value="{{$data->price}}" id="price">
    </div>
</form>


