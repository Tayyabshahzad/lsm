<div>
    <form wire:submit.prevent="savePricing">
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" wire:model="price" class="form-control">
            @error('price') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="billing_cycle">Billing Cycle</label>
            <select id="billing_cycle" wire:model="billing_cycle" class="form-control">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
            @error('billing_cycle') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="classes_per_week">Classes per Week</label>
            <input type="number" id="classes_per_week" wire:model="classes_per_week" class="form-control">
            @error('classes_per_week') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="course_duration">Course Duration (minutes)</label>
            <input type="number" id="course_duration" wire:model="course_duration" class="form-control">
            @error('course_duration') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="checkbox" id="is_best" wire:model="is_best">
            <label for="is_best">Is Best Pricing Option</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Pricing</button>
    </form>

    <h3>Existing Pricing Plans</h3>
    <ul>
        @foreach($pricings as $pricing)
            <li>
                {{ $pricing->price }} USD - {{ $pricing->billing_cycle }} - {{ $pricing->classes_per_week }} classes/week - {{ $pricing->course_duration }} mins/class
            </li>
        @endforeach
    </ul>
</div>
