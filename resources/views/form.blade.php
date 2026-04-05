<form action="/predict" method="POST">
  @csrf
  <input type="text" name="prediction" placeholder="Enter your prediction">
  <button type="submit">Submit</button>
</form>
@if(isset($prediction))
  <p>Prediction: {{ $prediction['result'] }}</p>
@endif
