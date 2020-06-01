@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="container">
            <h1><b>Create a new movie entry!</b></h1>
            <br />

            <!-- Create film form -->
            <table>
                <!-- name of the new film -->
                <tr>
                    <td>
                        Movie name:
                    </td>
                    <td style="padding-left: 1em;">
                        <input type="text" v-model="form_new_film_name" />
                    </td>
                </tr>

                <!-- space between the two rows, could be done better -->
                <tr><td><br /></td></tr>

                <!-- description -->
                <tr>
                    <td>
                        Movie description:
                    </td>
                    <td style="padding-left: 1em;">
                        <textarea rows = "5" cols = "60" name = "description">
                        </textarea>
                    </td>
                </tr>

                <!-- space between the two rows, could be done better -->
                <tr><td><br /></td></tr>

                <!-- submit button -->
                <tr>
                    <td></td>
                    <td style="padding-left: 1em;">
                        <input type="submit" value="Create film">
                    </td>
                </tr>
            </table>

        </div>
    </section>
@endsection
