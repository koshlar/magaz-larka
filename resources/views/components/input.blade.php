<div class="input_container">
  <label for="{{$name}}">{{$placeholder}}</label>
  <input id="{{$name}}" type="{{$type ?? 'text'}}" name="{{$name}}" value="{{@old($name)}}" placeholder="{{$placeholder}}">
  <!-- Отображение ошибки -->
  @error($name)
  <p class="error">{{$message}}</p>
  @enderror
</div>