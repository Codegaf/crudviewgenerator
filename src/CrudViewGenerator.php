<?php

namespace Codegaf\CrudViewGenerator;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CrudViewGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:viewgenerator {model} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera la parte front de un crud';

    protected $model;
    protected $modelCamelCase;
    protected $modelSnakeCase;
    protected $modelPlural;
    protected $modelKebab;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->model = $this->argument('model');
        $this->modelCamelCase = $this->setModelCamelCase($this->model);
        $this->modelPlural = $this->setModelPlural($this->model);
        $this->modelSnakeCase = $this->setModelSnakeCase($this->modelPlural);
        $this->modelKebab = $this->setModelKebab($this->modelCamelCase);

        $optionAll = $this->option('all');

        if ($optionAll) {
            $this->generateAll();
        }
        else {

            if ($this->confirm('Generar el index?')) {
                // Genera el archivo index
                $this->handleIndex();
            }

            if ($this->confirm('Generar el create?')) {
                // Genera el archivo create
                $this->handleCreate();
            }

            if ($this->confirm('Generar el edit?')) {
                // Genera el archivo edit
                $this->handleEdit();
            }

            if ($this->confirm('Generar el formulario create-edit?')) {
                // Genera el archivo create.edit.form
                $this->handleCreateEditForm();
            }
        }

        $this->info('CrudViewGenerator finalizado correctamente');

        return 0;
    }

    /**
     * Genera el archivo index
     */
    public function handleIndex() {
        $index = $this->getStub('index');
        $index = $this->replaceTextVariables(['{{ modelKebab }}', '{{ modelCamelCase }}'], [$this->modelKebab, $this->modelCamelCase], $index);
        $this->createPath($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase));
        $this->createFile($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase.'/index.blade.php'), $index);

        $this->info('Index creado correctamente');
    }

    /**
     * Genera el archivo create
     */
    public function handleCreate() {
        $create = $this->getStub('create');
        $create = $this->replaceTextVariables(['{{ modelKebab }}', '{{ modelCamelCase }}'], [$this->modelKebab, $this->modelCamelCase], $create);
        $this->createPath($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase));
        $this->createFile($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase.'/create.blade.php'), $create);

        $this->info('Create creado correctamente');
    }

    /**
     * Genera el archivo edit
     */
    public function handleEdit() {
        $edit = $this->getStub('edit');
        $edit = $this->replaceTextVariables(['{{ modelKebab }}', '{{ modelCamelCase }}'], [$this->modelKebab, $this->modelCamelCase], $edit);
        $this->createPath($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase));
        $this->createFile($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase.'/edit.blade.php'), $edit);

        $this->info('Edit creado correctamente');
    }

    /**
     * Genera el archivo create edit form
     */
    public function handleCreateEditForm() {
        $columns = config('models.'.$this->modelCamelCase.'.form');
        $form = $this->generateForm($columns);
        $createEditForm = $this->getStub('create.edit.form');
        $createEditForm = $this->replaceTextVariables(['{{ modelKebab }}', '{{ modelCamelCase }}', '{{ form }}'], [$this->modelKebab, $this->modelCamelCase, $form], $createEditForm);
        $this->createPath($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase));
        $this->createFile($this->laravel->resourcePath('/views/project/'.$this->modelCamelCase.'/create-edit-form.blade.php'), $createEditForm);

        $this->info('Create Edit Form creado correctamente');
    }

    /**
     * @param string $string
     * @return string
     */
    public function setModelCamelCase(string $string)
    {
        return Str::camel($string);
    }

    /**
     * @param string $string
     * @return string
     */
    public function setModelSnakeCase(string $string)
    {
        return Str::snake($string);
    }

    /**
     * @param string $string
     * @return string
     */
    public function setModelPlural(string $string)
    {
        return Str::plural($string);
    }

    /**
     * @param string $string
     * @return string
     */
    public function setModelKebab(string $string) {
        return Str::kebab($string);
    }

    public function generateForm($columns)
    {
        $form = '';
        foreach ($columns as $name => $column) {
            $id = array_key_exists('id', $column) ? $column['id'] : '';
            $idAttribute = $id ? 'id="'.$id.'"' : '';
            $label = $column['label'];
            switch ($column['input']) {
                case 'text':
                    $form .= '<x-inputs.text col="col-12 col-lg-6" name="' . $name . '" label="' . __($label) . '" '.$idAttribute.' value="{{old(\''.$name.'\', $'.$this->modelCamelCase.'->'.$name.' ?? \'\')}}" />' . PHP_EOL . PHP_EOL;
                    break;
                case 'email':
                    $form .= '<x-inputs.email col="col-12 col-lg-6" name="' . $name . '" '.$id.' label="' . __($label) . '" '.$idAttribute.' value="{{old(\''.$name.'\', $'.$this->modelCamelCase.'->'.$name.' ?? \'\')}}" />' . PHP_EOL . PHP_EOL;
                    break;
                case 'date':
                    $form .= '<x-inputs.date col="col-12 col-lg-6" '.$idAttribute.' label="'.__($label).'" name="'.$name.'" value="{{old(\''.$name.'\', $'.$this->modelCamelCase.'->'.$name.' ?? \'\')}}" />' . PHP_EOL . PHP_EOL;
                    break;
                case 'time':
                    $form .= '<x-inputs.time col="col-12 col-lg-6" '.$idAttribute.' label="'.__($label).'" name="'.$name.'" value="{{old(\''.$name.'\', $'.$this->modelCamelCase.'->'.$name.' ?? \'\')}}" />' . PHP_EOL . PHP_EOL;
                    break;
                case 'textarea':
                    $form .= '<x-textareas.textarea col="col-12 col-lg-6" rows="6" label="'.__($label).'" name="'.$name.'" value="{{old(\''.$name.'\', $'.$this->modelCamelCase.'->'.$name.' ?? \'\')}}" />' . PHP_EOL . PHP_EOL;
                    break;
            }
        }

        return $form;
    }

    /**
     * @param array $search
     * @param array $replace
     * @param $text
     * @return string|string[]
     */
    public function replaceTextVariables(array $search, array $replace, $text) {
        return str_replace($search, $replace, $text);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getStub(string $name) {
        return file_get_contents(base_path('vendor/codegaf/crudviewgenerator/src/stubs/custom/'.$name.'.stub'));
    }

    /**
     * Crea un directorio si no existe
     * @param $path
     */
    public function createPath($path) {
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    /**
     * Crea el archivo
     * @param $path
     * @param $content
     */
    public function createFile($path, $content) {
        file_put_contents($path, $content);
    }

    /**
     * Si el usuario ha elegido la opción all se crean el crud completo
     */
    public function generateAll() {
        // Genera el archivo index
        $this->handleIndex();

        // Genera el archivo create
        $this->handleCreate();

        // Genera el archivo edit
        $this->handleEdit();

        // Genera el archivo create.edit.form
        $this->handleCreateEditForm();
    }
}
