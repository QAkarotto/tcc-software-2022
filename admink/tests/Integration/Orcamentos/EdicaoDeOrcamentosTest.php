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

class EdicaoDeOrcamentosTest extends TestCase
{

    public function teste1EdicaoDeOrcamentoComSucessoSemDadosDeTatuador()
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
                '_method'               => 'PUT',
                'cliente'               => $cliente->id_cliente,
                'artista'               => $artista->id_artista,
                'tatuagem_nome'         => 'Teste Edição Orçamento',
                'tatuagem_local'        => 'Teste Edição Orçamento',
                'tatuagem_comprimento'  => 13,
                'tatuagem_largura'      => 13,
                'tatuagem_descricao'    => 'Teste Orçamento Editado com Sucesso!',
                'tatuagem_referencias'  => 'testeedicaoorcamento.com.br',
                'canal_contato'         => 'Teste Edição',
                'tempo_estimado'        => null,
                'valor'                 => null,
                'uso_materiais'         => null,
                'complexidade'          => null,
                'observacao'            => null
            ]);
        $response->assertStatus(302);
        $response->assertSessionHas('success_toastr', 'O orçamento foi atualizado com sucesso!');
    }

    public function teste2EdicaoDeOrcamentoComSucessoComDadosDeTatuador()
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
                '_method'               => 'PUT',
                'cliente'               => $cliente->id_cliente,
                'artista'               => $artista->id_artista,
                'tatuagem_nome'         => 'Teste Edição Orçamento',
                'tatuagem_local'        => 'Teste Edição Orçamento',
                'tatuagem_comprimento'  => 13,
                'tatuagem_largura'      => 13,
                'tatuagem_descricao'    => 'Teste Orçamento Editado com Sucesso!',
                'tatuagem_referencias'  => 'testeedicaoorcamento.com.br',
                'canal_contato'         => 'Teste Edição',
                'tempo_estimado'        => '03:00',
                'valor'                 => '13,00',
                'uso_materiais'         => 1,
                'complexidade'          => 1,
                'observacao'            => 'Teste Edição de Orçamento com sucesso com dados de tatuador!'
            ]);
        $response->assertStatus(302);
        $response->assertSessionHas('success_toastr', 'O orçamento foi atualizado com sucesso!');
    }

    public function teste3EdicaoDeOrcamentoComFalhaDadosObrigatoriosVazios()
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
                '_method'               => 'PUT',
                'cliente'               => null,
                'artista'               => null,
                'tatuagem_nome'         => '',
                'tatuagem_local'        => '',
                'tatuagem_comprimento'  => null,
                'tatuagem_largura'      => null,
                'tatuagem_descricao'    => '',
                'tatuagem_referencias'  => null,
                'canal_contato'         => null,
                'tempo_estimado'        => null,
                'valor'                 => null,
                'uso_materiais'         => null,
                'complexidade'          => null,
                'observacao'            => null
            ]);
        $response->assertStatus(302);
        $this->assertEquals(session('errors')->get('cliente')[0], 'O campo cliente é obrigatório.');
        $this->assertEquals(session('errors')->get('artista')[0], 'O campo artista é obrigatório.');
        $this->assertEquals(session('errors')->get('tatuagem_nome')[0], 'O campo tatuagem nome é obrigatório.');
        $this->assertEquals(session('errors')->get('tatuagem_local')[0], 'O campo tatuagem local é obrigatório.');
        $this->assertEquals(session('errors')->get('tatuagem_comprimento')[0], 'O campo tatuagem comprimento é obrigatório.');
        $this->assertEquals(session('errors')->get('tatuagem_largura')[0], 'O campo tatuagem largura é obrigatório.');
        $this->assertEquals(session('errors')->get('tatuagem_descricao')[0], 'O campo tatuagem descricao é obrigatório.');
    }

    public function teste4EdicaoDeOrcamentoComFalhaDadosComTamanhoMaiorQueOSuportado()
    {   
        include  'TestStrings.php';
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
                '_method'               => 'PUT',
                'cliente'               => 2147483648,
                'artista'               => 2147483648,
                'tatuagem_nome'         => $stringCom61Caracteres,
                'tatuagem_local'        => $stringCom61Caracteres,
                'tatuagem_comprimento'  => 201,
                'tatuagem_largura'      => 201,
                'tatuagem_descricao'    => $stringCom256Caracteres,
                'tatuagem_referencias'  => $stringCom65536Caracteres,
                'canal_contato'         => 2147483648,
                'tempo_estimado'        => '24:00:00',
                'valor'                 => '100.000,00',
                'uso_materiais'         => 2147483648,
                'complexidade'          => 2147483648,
                'observacao'            => $stringCom256Caracteres
            ]);

        $response->assertStatus(302);
        $this->assertEquals(session('errors')->get('tatuagem_nome')[0], 'O campo tatuagem nome não pode ser superior a 60 caracteres.');
        $this->assertEquals(session('errors')->get('tatuagem_local')[0], 'O campo tatuagem local não pode ser superior a 60 caracteres.');
        $this->assertEquals(session('errors')->get('tatuagem_comprimento')[0], 'O campo tatuagem comprimento não pode ser superior a 200.');
        $this->assertEquals(session('errors')->get('tatuagem_largura')[0], 'O campo tatuagem largura não pode ser superior a 200.');
        $this->assertEquals(session('errors')->get('tatuagem_descricao')[0], 'O campo tatuagem descricao não pode ser superior a 255 caracteres.');
        $this->assertEquals(session('errors')->get('valor')[0], 'O campo valor tem um formato inválido.');
        $this->assertEquals(session('errors')->get('tempo_estimado')[0], 'O campo tempo estimado tem um formato inválido.');
        $this->assertEquals(session('errors')->get('observacao')[0], 'O campo observacao não pode ser superior a 255 caracteres.');
    }

    public function teste5EdicaoDeOrcamentoComFalhaDadosComTiposDiferentesDoSuportado()
    {
        include  'TestStrings.php';
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
                '_method'               => 'PUT',
                'cliente'               => 'String ao invés de inteiro',
                'artista'               => 'String ao invés de inteiro',
                'tatuagem_nome'         => 73273,
                'tatuagem_local'        => 73273,
                'tatuagem_comprimento'  => 'String ao invés de inteiro',
                'tatuagem_largura'      => 'String ao invés de inteiro',
                'tatuagem_descricao'    => ['array ao invés', 'de string'],
                'tatuagem_referencias'  => 73273,
                'canal_contato'         => ['array ao invés', 'de string'],
                'tempo_estimado'        => 1643067873,
                'valor'                 => 100000.00,
                'uso_materiais'         => 'String ao invés de inteiro',
                'complexidade'          => 'String ao invés de inteiro',
                'observacao'            => $stringCom256Caracteres
            ]);
        $response->assertStatus(302);
        $this->assertEquals(session('errors')->get('tatuagem_nome')[0], 'O campo tatuagem nome deve ser uma string.');
        $this->assertEquals(session('errors')->get('tatuagem_local')[0], 'O campo tatuagem local deve ser uma string.');
        $this->assertEquals(session('errors')->get('tatuagem_comprimento')[0], 'O campo tatuagem comprimento deve ser um número.');
        $this->assertEquals(session('errors')->get('tatuagem_largura')[0], 'O campo tatuagem largura deve ser um número.');
        $this->assertEquals(session('errors')->get('tatuagem_descricao')[0], 'O campo tatuagem descricao deve ser uma string.');
        $this->assertEquals(session('errors')->get('valor')[0], 'O campo valor tem um formato inválido.');
        $this->assertEquals(session('errors')->get('tempo_estimado')[0], 'O campo tempo estimado tem um formato inválido.');
        $this->assertEquals(session('errors')->get('observacao')[0], 'O campo observacao não pode ser superior a 255 caracteres.');
    }
}