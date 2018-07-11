@extends('Layouts.app')

@section('content')

    <table id="words" class="display">
        <thead>
        <tr>
            <th>Word</th>
            <th>Definition</th>
            <th>Synonyms</th>
        </tr>
        </thead>
        <tbody>

        <?php
            foreach ($words as $word)
            {
                $results = json_decode($word['api_result'], true)['results'];

                $limit = getenv('DEFINITION_LIMIT_INDEX_PAGE', 1);
                $i = 0;
                foreach ($results as $result)
                {
                    echo '<tr>'.PHP_EOL;
                    echo '<td><a href=" '.route('words.show', $word->id).'">'.$word->word.'</a></td>'.PHP_EOL;
                    echo '<td>'.$result['definition'].'</td>'.PHP_EOL;
                    if(isset($result['synonyms']))
                    {
                        echo '<td>'.implode(',', $result['synonyms']).PHP_EOL;
                    }
                    else {
                        echo '<td></td>';
                    }
                    echo '</tr>'.PHP_EOL;

                    $i++;
                    if($i >= $limit) break;
                }


            }
        ?>

        </tbody>
    </table>
    <div class="container" style="text-align: center; ">
        <form name="newWord" method="post" action="{{ route('words.store') }}">
            <label for="word">Word: </label><input type="text" name="word" id="word" /><br/>
            <input type="submit" class="btn btn-primary"/>
            {{ csrf_field() }}
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#words').DataTable();
        } );
    </script>

@endsection