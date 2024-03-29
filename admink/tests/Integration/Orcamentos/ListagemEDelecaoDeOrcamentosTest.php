<?php

namespace Tests\Integration\Orcamentos;

use Tests\TestCase;
use App\User;
use App\EstudioUsers;
use App\Orcamento;
use App\Estudio;
use App\Cliente;
use App\Artista;
use App\ArtistaEstudio;
use App\ClienteEstudio;
use App\Estacao;
use App\Agendamento;

class ListagemEDelecaoDeOrcamentosTest extends TestCase
{

    public function teste1ListagemDeOrcamentosComSucesso()
    {
        $user = factory(User::class)->create();
        $estudio = factory(Estudio::class)->create();
        factory(EstudioUsers::class)->create(['fk_users_id_users' => $user->id, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        $artista = factory(Artista::class)->create();
        $cliente = factory(Cliente::class)->create();
        factory(ArtistaEstudio::class)->create(['fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        factory(ClienteEstudio::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        $orcamento = factory(Orcamento::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio, 'fk_orcamento_status_id_orcamento_status' => 1]);
        $orcamento2 = factory(Orcamento::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio, 'fk_orcamento_status_id_orcamento_status' => 1]);

        $response = $this->actingAs($user)
            ->get('/admin/orcamentos');

        $response->assertStatus(200);
        $response->assertSee('<td class="align-middle">' . $orcamento->tatuagem_nome . '</td>', $escaped = false);
        $response->assertSee('<td class="align-middle">#' . str_pad($orcamento->id_orcamento, 5, '0', STR_PAD_LEFT) . '</td>', $escaped = false);
        $response->assertSee('<td class="align-middle">' . $orcamento2->tatuagem_nome . '</td>', $escaped = false);
        $response->assertSee('<td class="align-middle">#' . str_pad($orcamento2->id_orcamento, 5, '0', STR_PAD_LEFT) . '</td>', $escaped = false);
    }

    public function teste2ExclusaoDeOrcamentoNaoAgendadoComSucesso()
    {
        $user = factory(User::class)->create();
        $estudio = factory(Estudio::class)->create();
        factory(EstudioUsers::class)->create(['fk_users_id_users' => $user->id, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        $artista = factory(Artista::class)->create();
        $cliente = factory(Cliente::class)->create();
        factory(ArtistaEstudio::class)->create(['fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        factory(ClienteEstudio::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        $orcamento = factory(Orcamento::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio, 'fk_orcamento_status_id_orcamento_status' => 1]);

        $response = $this->actingAs($user)
            ->post('/admin/orcamentos/' . $orcamento->id_orcamento, [
                '_method'   => 'DELETE'
            ]);
        $response->assertStatus(302);
        $response->assertSessionHas('success_toastr',  'O orçamento foi excluído com sucesso!');
    }

    public function teste3ExclusaoDeOrcamentoAgendadoComSucesso()
    {
        $user = factory(User::class)->create();
        $estudio = factory(Estudio::class)->create();
        factory(EstudioUsers::class)->create(['fk_users_id_users' => $user->id, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        $artista = factory(Artista::class)->create();
        $cliente = factory(Cliente::class)->create();
        factory(ArtistaEstudio::class)->create(['fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        factory(ClienteEstudio::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_estudio_id_estudio' => $estudio->id_estudio]);
        $orcamento = factory(Orcamento::class)->create(['fk_cliente_id_cliente' => $cliente->id_cliente, 'fk_artista_id_artista' => $artista->id_artista, 'fk_estudio_id_estudio' => $estudio->id_estudio, 'fk_orcamento_status_id_orcamento_status' => 2, 'tempo_estimado' => '  02:00:00', 'valor' => 500.00, 'fk_uso_materiais_id_uso_materiais' => 1, 'fk_complexidade_id_complexidade' => 1, 'observacao' => 'teste3ExclusaoDeOrcamentoAgendadoComSucesso']);
        $estacao = factory(Estacao::class)->create(['fk_estudio_id_estudio' => $estudio->id_estudio]);
        factory(Agendamento::class)->create(['fk_orcamento_id_orcamento' => $orcamento->id_orcamento, 'fk_estacao_id_estacao' => $estacao->id_estacao, 'fk_agendamento_status_id_agendamento_status' => 1]);
        $orcamento->fk_orcamento_status_id_orcamento_status = 3;
        $orcamento->save();

        $response = $this->actingAs($user)
            ->post('/admin/orcamentos/' . $orcamento->id_orcamento, [
                '_method'   => 'DELETE'
            ]);
        $response->assertStatus(302);
        $response->assertSessionHas('success_toastr',  'O orçamento foi excluído com sucesso!');
    }
}