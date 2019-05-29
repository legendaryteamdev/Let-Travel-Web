                    <br />
                    @if (count($errors) > 0)
                        <div class="form-error-text-block">
                            <h2 style="color:red"> Error Occurs</h2>
                            <ul>    
                                
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif