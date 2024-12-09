<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            ['title' => 'Corrigir erro de layout', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '05/12/2024 14:45'), 'status' => 'pending'],
            ['title' => 'Criar layout do painel', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '06/12/2024 10:45'), 'status' => 'pending'],
            ['title' => 'Testar integração com pagamento', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '06/12/2024 14:20'), 'status' => 'pending'],
            ['title' => 'Adicionar validação de formulário', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '05/12/2024 08:20'), 'status' => 'pending'],
            ['title' => 'Escrever testes unitários', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '05/12/2024 11:35'), 'status' => 'completed'],
            ['title' => 'Atualizar API de produtos', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '06/12/2024 11:30'), 'status' => 'in-progress'],
            ['title' => 'Corrigir erro no relatório', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '06/12/2024 15:00'), 'status' => 'in-progress'],
            ['title' => 'Configurar servidor de e-mail', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '05/12/2024 13:10'), 'status' => 'completed'],
            ['title' => 'Implementar autenticação', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '06/12/2024 13:15'), 'status' => 'completed'],
            ['title' => 'Ajustar responsividade', 'created_at' => Carbon::createFromFormat('d/m/Y H:i', '06/12/2024 16:10'), 'status' => 'completed'],
        ];

        DB::table('tasks')->insert($tasks);
    }
}
