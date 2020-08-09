<form method="post" action="{{ route('list-subscription-store') }}">
@csrf

    <div class="form-group ">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" value="" id="name" placeholder="Required">
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
    <input class="form-control" name="price" type="text" placeholder="Required" value="" id="price">
    </div>
    <div class="form-group ">
 
   
</form>
