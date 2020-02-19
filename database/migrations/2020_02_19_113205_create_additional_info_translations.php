<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class CreateAdditionalInfoTranslations extends Migration
{
    public function __construct()
    {
        $this->output = new ConsoleOutput();

        $this->tables = collect([
            'age' => [
                'remove' => ['title'],
                'from' => 'ages',
            ]
        ]);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $key => $type) {
            // inizializzo il contenitore per i valori esistenti
            $this->output->writeln('------------ Ottengo i risultati di '.$type['from']);
            $results = $this->getResults($type['from']);
            // $this->output->writeln(var_dump($results));
            $this->output->writeln('fatto');

            $this->output->writeln('------------ Elimino le colonne');
            $removeColumns = $this->dropColumns($type);
            $this->output->writeln(var_dump($removeColumns));

            $this->output->writeln('------------ Creo la tabella '.$key.'_translations');
            $createTable = $this->createTable($key, $type);
            $this->output->writeln(var_dump($createTable));

            $this->output->writeln('------------ Incollo i dati nella tabella '.$key.'_translations');
            $pasteResults = $this->pasteResults($key, $type, $results);
            $this->output->writeln(var_dump($pasteResults));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $key => $type) {
            $this->output->writeln('------------ Ottengo i risultati di '.$key.'_translations');
            $results = $this->getResults($key.'_translations');
            // $this->output->writeln(var_dump($results));
            $this->output->writeln('fatto');

            $this->output->writeln('------------ Elimino la tabella '.$key.'_translations');
            $removeTable = $this->dropTable($key.'_translations');
            $this->output->writeln(var_dump($removeTable));

            $this->output->writeln('------------ Ripristino le colonne');
            $restoreColumns = $this->restoreColumns($key, $type);
            $this->output->writeln(var_dump($restoreColumns));

            $this->output->writeln('------------ Ripristino i dati nella tabella '.$type['from']);
            $restoreData = $this->restoreData($key, $type, $results);
            $this->output->writeln(var_dump($restoreData));
        }
    }

    public function pasteResults($key, $type, $results)
    {
        $formatted = $results->transform(function ($result, $resultKey) use ($type, $key) {
            $newResult = array();
            $newResult[$key.'_id'] = $result->id;
            $newResult['locale'] = 'it';

            foreach ($type['remove'] as $removeItemKey => $removeItem) {
                $newResult[$removeItem] = $result->{$removeItem};
            }
            return $newResult;
        })->all();

        // $this->output->writeln(var_dump($formatted));

        DB::connection('tfc_propaganda')->table($key.'_translations')->insert($formatted);

        return true;
    }

    public function restoreData($key, $type, $results)
    {
        foreach ($results as $resultKey => $result) {
            $newResult = array();

            foreach ($type['remove'] as $removeItemKey => $removeItem) {
                $newResult[$removeItem] = $result->{$removeItem};
            }

            $json = json_encode($newResult);
            $formatted = json_decode($json, true);


            DB::connection('tfc_propaganda')->table($type['from'])
              ->where('id', $result->{$key.'_id'})
              ->update($formatted);
        }
        return true;
    }

    public function createTable($key, $type)
    {
        Schema::connection('tfc_propaganda')->create($key.'_translations', function (Blueprint $table) use ($key, $type) {
            $table->increments('id');
            $table->integer($key.'_id')->unsigned();

            foreach ($type['remove'] as $removeItemKey => $removeItem) {
                $table->string($removeItem);
            }
            $table->string('locale')->index();

            $table->unique([$key.'_id', 'locale']);
            $table->foreign($key.'_id')->references('id')->on($type['from']);
        });
        return true;
    }

    public function dropColumns($type)
    {
        Schema::connection('tfc_propaganda')->table($type['from'], function (Blueprint $table) use ($type) {
            foreach ($type['remove'] as $removeItemKey => $removeItem) {
                $table->dropColumn($removeItem);
            }
        });

        return true;
    }

    public function restoreColumns($key, $type)
    {
        Schema::connection('tfc_propaganda')->table($type['from'], function (Blueprint $table) use ($type) {
            foreach ($type['remove'] as $removeItemKey => $removeItem) {
                $table->string($removeItem)->nullable();
            }
        });

        return true;
    }

    public function dropTable($tableName)
    {
        Schema::connection('tfc_propaganda')->dropIfExists($tableName);
        return true;
    }

    public function getResults($tableName)
    {
        return DB::connection('tfc_propaganda')->table($tableName)->get();
    }


    public function getContentsBeforeDelete($tableName, $columnName)
    {
        return DB::connection('tfc_propaganda')->table($tableName)->pluck($columnName, 'id');
    }
}
