<?php

namespace EmVista\EmVistaBundle\Services;

use EmVista\EmVistaBundle\Entity\StatusArrecadacao;
use EmVista\EmVistaBundle\Entity\StatusDoacao;
use EmVista\EmVistaBundle\Entity\StatusFinanceiro;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\TermoUso;
use EmVista\EmVistaBundle\Entity\Categoria;
use EmVista\EmVistaBundle\Entity\Recompensa;
use Symfony\Component\Serializer\Serializer;
use EmVista\EmVistaBundle\Entity\Atualizacao;
use EmVista\EmVistaBundle\Entity\TipoProjetoImagem;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceAbstract;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Services\Exceptions\ProjetoNaoEncontradoException;

class ProjetoService extends ServiceAbstract
{
    /**
     * @var float
     */
    protected $percentualPlataforma;

    /**
     * @param float $percentualPlataforma
     */
    public function setPercentualPlataforma($percentualPlataforma)
    {
        $this->percentualPlataforma = $percentualPlataforma;

        return $this;
    }

    /**
     * @param  integer $id
     * @return Projeto
     */
    public function getProjeto($id)
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Projeto')->find($id);
    }

    /**
     * @param  string  $id
     * @return Projeto
     */
    public function getProjetoBySlug(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $projeto = $em->getRepository('EmVistaBundle:Projeto')->findOneBy(array('slug' => $sd->get('slug')));

        if (empty($projeto)) {
            throw new ProjetoNaoEncontradoException();
        }

        return $projeto;
    }

    /**
     * @param  integer    $id
     * @return Recompensa
     */
    public function getRecompensa($id)
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Recompensa')->find($id);
    }

    /**
     * @param  ServiceData      $data
     * @param  string           $data['nome']
     * @param  optional integer $data['id']
     * @return Categoria
     */
    public function salvarCategoria(ServiceData $data)
    {
        try {
            $data = $data->get();
            $validator = $this->getValidator();
            $em = $this->getEntityManager();

            $validator::arr()->key('nome', $validator::string()->length(2, 100))
                             ->check($data);

            if (array_key_exists('id', $data) && !empty($data['id'])) {
                $validator::numeric()->check($data['id']);
                $categoria = $em->find('EmVistaBundle:Categoria', $data['id']);
            } else {
                $categoria = new Categoria();
            }

            $categoria->setNome($data['nome']);

            $em->beginTransaction();
            $em->persist($categoria);
            $em->flush();
            $em->commit();

            return $categoria;

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        } catch (Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @return Categoria[]
     */
    public function listarCategorias()
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Categoria')->findBy(array(), array('nome' => 'ASC'));
    }

    /**
     * @return Categoria[]
     */
    public function listarCategoriasComProjetos()
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Categoria')->listarCategoriasComProjetos();
    }

    /**
    * Lista os projetos que estão proximos de acabar
    * @return Projeto[]
    */
    public function listarProjetosRetaFinal()
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Projeto')
                    ->listarProjetosRetaFinal();
    }

    /**
    * Lista os projetos novos
    * @return Projeto[]
    */
    public function listarProjetosNovos()
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Projeto')
                    ->listarProjetosNovos();
    }

    /**
    * Lista os projetos finalizados sem sucesso e ainda não estornados
    * @return Projeto[]
    */
    public function listarProjetosFinalizadosSemSucessoNaoEstornados()
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Projeto')
                    ->listarProjetosFinalizadosSemSucessoNaoEstornados();
    }

    /**
    * Lista os projetos concluidos que nao pagos
    * @return Projeto[]
    */
    public function listarProjetosConcluidosNaoPagos()
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Projeto')
                    ->listarProjetosConcluidosNaoPagos();
    }

    /**
     * @return mixed[]
     */
    public function listarProjetosRepasse()
    {
        $projetoRepository = $this->getEntityManager()->getRepository('EmVistaBundle:Projeto');

        $projetos = $this->listarProjetosConcluidosNaoPagos();

        $result = array();
        foreach ($projetos as $projeto) {
            $liquidoETaxa = $projetoRepository->calcularValorLiquidoETaxa($projeto);

            $item = array();
            $item['projeto'] = $projeto;
            $item['contribuicoes'] = $this->countDoacoes(ServiceData::build(array('projetoId' => $projeto->getId())));
            $item['valorLiquido'] = $liquidoETaxa['valorLiquido'];
            $item['valorRepasse'] = $item['valorLiquido'] - ($projeto->getValorArrecadado() * $this->percentualPlataforma);
            $item['taxas'] = $liquidoETaxa['taxa'];;

            $result[] = $item;
        }

        return $result;
    }

    /**
     * Retorna quantidade de doacoes aprovadas feitas em um projeto
     * @param  ServiceData $sd
     * @return integer
     */
    public function countDoacoes(ServiceData $sd)
    {
        $em = $this->getEntityManager();

        return (int) $em->getRepository('EmVistaBundle:Doacao')->countDoacoesAprovadasEEstornadasByProjetoId($sd->get('projetoId'));
    }

    /**
     * @return type
     */
    public function listarProjetosPublicados()
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Projeto')->findBy(array('publicado' => true));
    }

    /**
     * @param  type $idCategoria
     * @return type
     */
    public function listarProjetosPublicadosPorCategoria($idCategoria)
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Projeto')->findBy(array('publicado' => true, 'categoria' => $idCategoria));
    }

    /**
     * Salva atualizacao
     * @param ServiceData
     */
    public function salvarAtualizacao(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $atualizacao = new Atualizacao();
        $projeto = $em->find('EmVistaBundle:Projeto', $sd->get('projetoId'));
        $atualizacao->setProjeto($projeto);
        $atualizacao->setTitulo($sd->get('titulo'));
        $atualizacao->setTexto($sd->get('texto'));
        $em->persist($atualizacao);
        $em->flush();

        return $projeto;
    }

    /**
     * Retorna atualizacoes
     * @param  integer       $projetoId
     * @return Atualizacao[]
     */
    public function listarAtualizacoes(ServiceData $sd)
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Atualizacao')
                    ->findBy(array('projeto' => $sd->get('projetoId')));
    }

    /**
     * Retorna os projetos enviados por um usuario
     * @param  ServiceData $sd
     * @return Projeto[]
     */
    public function listarProjetosPorUsuario(ServiceData $sd)
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Projeto')
                    ->findBy(array('usuario' => $sd->getUser()->getId()));
    }

    /**
     * Lista as contribuicoes de um usuario
     * @param  ServiceData $sd
     * @return Doacao[]
     */
    public function listarDoacoesPorUsuario(ServiceData $sd)
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Doacao')
                    ->findBy(array('usuario' => $sd->getUser()->getId()), array('dataCadastro' => 'DESC'));
    }

    /**
     * Realiza busca de projetos
     * @param  ServiceData $sd
     * @return Projeto[]
     */
    public function busca(ServiceData $sd)
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:Projeto')->busca($sd->get('text'));
    }

    /**
     *
     * @return TermoUso
     */
    public function getTermoUsoVigente()
    {
        $em = $this->getEntityManager();
        $termoUso = $em->getRepository('EmVistaBundle:TermoUso')->findOneBy(array('ativo' => true));

        return $termoUso;
    }

    /**
     *
     * @param  ServiceData                            $data
     * @param  string                                 $data['termoUso']
     * @return \EmVista\EmVistaBundle\Entity\TermoUso
     * @throws ServiceValidationException
     * @throws InvalidArgumentException
     */
    public function salvarTermoUso(ServiceData $data)
    {
        try {
            $data = $data->get();
            $validator = $this->getValidator();
            $em = $this->getEntityManager();

            $validator::arr()->key('termoUso', $validator::string()->length(10))
                             ->check($data);

            $termoUso = new TermoUso();
            $termoUso->setAtivo(true);
            $termoUso->setTermoUso($data['termoUso']);

            $em->beginTransaction();

            $termoUsoAntigo = $this->getTermoUsoVigente();
            if (isset($termoUsoAntigo) && $termoUsoAntigo ) {
                $termoUsoAntigo->setAtivo(false);
                $termoUsoAntigo->setDataFim(new \DateTime('now'));
                $em->persist($termoUsoAntigo);
            }

            $em->persist($termoUso);
            $em->flush();
            $em->commit();

            return $termoUso;
        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        } catch (Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param ServiceData $sd
     * @param integer     $sd['projetoId']
     */
    public function getImagemOriginal(ServiceData $sd)
    {
        try {
            $v = $this->getValidator();
            $v::arr()->key('projetoId', $v::int())->check($sd->get());

            $em = $this->getEntityManager();
            $repository = $em->getRepository('EmVistaBundle:ProjetoImagem');

            // se retornar a imagem original se todas as imagens e crops foram feitos com sucesso
            if (count($repository->findBy(array('projeto' => $sd->get('projetoId')))) == 2) {
                return $repository->findOneBy(array('projeto' => $sd->get('projetoId'),
                                                    'tipoProjetoImagem' => TipoProjetoImagem::TIPO_ORIGINAL));
            }

            return null;

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        }
    }

    public function getImagemThumb(ServiceData $sd)
    {
        try {
            $v = $this->getValidator();
            $v::arr()->key('projetoId', $v::int())->check($sd->get());

            $em = $this->getEntityManager();
            $repository = $em->getRepository('EmVistaBundle:ProjetoImagem');

            // se retornar a imagem original se todas as imagens e crops foram feitos com sucesso
            if (count($repository->findBy(array('projeto' => $sd->get('projetoId')))) == 2) {
                return $repository->findOneBy(array('projeto' => $sd->get('projetoId'),
                    'tipoProjetoImagem' => TipoProjetoImagem::TIPO_THUMB));
            }

            return null;

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        }
    }

    /**
     * @param  ServiceData $data
     * @param  String      $data['search]
     * @return Projeto[]
     */
    public function search(ServiceData $data)
    {
        $q = $data->get('search');
        $q = filter_var(trim($q), FILTER_SANITIZE_STRING);
        
        $em = $this->getEntityManager();
        
        $categoria = $em->getRepository('EmVistaBundle:Categoria')->findOneBy(array('slug' => $q));
        
        if ($categoria) { 
            return $em->getRepository('EmVistaBundle:Projeto')
                      ->findBy(array('categoria' => $categoria->getId(), 'publicado' => true));
        }
       
        return array();
    }

    /**
     * atualiza a quantidade de projetos em cada recompensa cadastrada
     */
    public function atualizarQuantidadeProjetosNasRecompensas()
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
        try {
            $categorias = $em->getRepository('EmVistaBundle:Categoria')->findAll();
            foreach ($categorias as $categoria) {
                $projetos = $em->getRepository('EmVistaBundle:Projeto')->findBy(array('publicado' => true,
                                                                                      'categoria' => $categoria->getId()));
                $categoria->setQuantidadeProjetosPublicados(count($projetos));
                $em->persist($categoria);
            }
            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * verifica se o usuário ja apoiou o projeto
     * @param  ServiceData $sd
     * @param  Usuario     $sd['user']
     * @param  Projeto     $sd['projetoId']
     * @return boolean
     */
    public function hasDoacaoUsuarioProjeto(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        try {
            $usuario = $sd->getUser();

            if ($usuario == 'anon.') {
                return false;
            }

            $projeto = $em->find('EmVistaBundle:Projeto', $sd->get('projetoId'));
            $doacoes = $em->getRepository('EmVistaBundle:Doacao')->listarDoacoesUsuarioProjeto($usuario, $projeto);

            if (count($doacoes) > 0) {
                return true;
            }

            return false;

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        }
    }

    /**
     * @param  ServiceData                $sd
     * @return type
     * @throws ServiceValidationException
     */
    public function listApoiadoresProjeto(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $projeto = $em->find('EmVistaBundle:Projeto', $sd->get('projetoId'));

        return $em->getRepository('EmVistaBundle:Usuario')->listarApoiadoresByProjeto($projeto);
    }


    public function getMore(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $projetos = $em->getRepository('EmVistaBundle:Projeto')->getMore($sd->get('lastProjectId'), $sd->get('count'));
        return $projetos;
    }


    public function finalizaProjetosAbertosQueFinalizamHoje(ServiceData $sd)
    {
        $em = $this->getEntityManager();


        $date = new \DateTime($sd->get('date'));
        $projetos = $em->getRepository('EmVistaBundle:Projeto')->listaProjetosPublicadosNaoFinalizadosByData($date);
        //$projetos = $em->getRepository('EmVistaBundle:Projeto')->findBy(array('publicado' => true));

        foreach ($projetos as $projeto){
            /**
             * @var Projeto $projeto
             */
            $hasPendente = false;
            foreach ($projeto->getRecompensas() as $recompensa) {
                foreach ($recompensa->getDoacoes() as $doacao) {
                    if ($doacao->getStatus()->getId() == StatusDoacao::PENDENTE ||
                        $doacao->getStatus()->getId() == StatusDoacao::AGUARDANDO) {
                        $hasPendente = true;
                    }
                }
            }

            if ($hasPendente) {
                $projeto->setStatusArrecadacao($em->getRepository('EmVistaBundle:StatusArrecadacao')->find(StatusArrecadacao::STATUS_AGUARDANDO_BOLETO));
            } else {
                if ($projeto->getValorArrecadado() >= $projeto->getValor()) {
                    $projeto->setStatusArrecadacao($em->getRepository('EmVistaBundle:StatusArrecadacao')->find(StatusArrecadacao::STATUS_SUCESSO));
                } else {
                    $projeto->setStatusArrecadacao($em->getRepository('EmVistaBundle:StatusArrecadacao')->find(StatusArrecadacao::STATUS_INSUCESSO));
                }
            }

            if ($projeto->getValor() == 0) {
                $projeto->setStatusFinanceiro($em->getRepository('EmVistaBundle:StatusFinanceiro')->find(StatusFinanceiro::STATUS_ESTORNADO));
            }
            $em->persist($projeto);
            $em->flush();
        }
    }

    public function pagamentoNaoConfirmadoExpirados()
    {
        foreach ($projetos as $projeto){
            /**
             * @var Projeto $projeto
             */
            $hasPendente = false;
            foreach ($projeto->getRecompensas() as $recompensa) {
                foreach ($recompensa->getDoacoes() as $doacao) {
                    if (($doacao->getStatus()->getId() == StatusDoacao::PENDENTE ||
                        $doacao->getStatus()->getId() == StatusDoacao::AGUARDANDO))
                         {
                        $hasPendente = true;
                    }
                }
            }

            if ($hasPendente) {
                $projeto->setStatusArrecadacao($em->getRepository('EmVistaBundle:StatusArrecadacao')->find(StatusArrecadacao::STATUS_AGUARDANDO_BOLETO));
            } else {
                if ($projeto->getValorArrecadado() >= $projeto->getValor()) {
                    $projeto->setStatusArrecadacao($em->getRepository('EmVistaBundle:StatusArrecadacao')->find(StatusArrecadacao::STATUS_SUCESSO));
                } else {
                    $projeto->setStatusArrecadacao($em->getRepository('EmVistaBundle:StatusArrecadacao')->find(StatusArrecadacao::STATUS_INSUCESSO));
                }
            }
            $em->persist($projeto);
            $em->flush();
        }
    }
    
    /**
     * @param ServiceData $sd
     * @return Doacao[]
     */
    public function listarDoacoesParaEstorno(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        
        $doacoes = $em->getRepository('EmVistaBundle:Doacao')
                      ->listarDoacoesParaEstorno($sd->get('projetoId'));
        
        return $doacoes;
    }
    
    /**
     * @param ServiceData $sd
     * @return Doacao
     */
    public function estornarDoacao(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        
        $status = $em->find('EmVistaBundle:StatusDoacao', StatusDoacao::ESTORNADO);
        
        $doacao = $em->find('EmVistaBundle:Doacao', $sd->get('doacaoId'));
        $doacao->setStatus($status);
        
        $em->persist($doacao);
        $em->flush();
        
        $doacoesRestantes = $em->getRepository('EmVistaBundle:Doacao')
                               ->listarDoacoesParaEstorno($doacao->getRecompensa()->getProjeto()->getId());
        
        if (empty($doacoesRestantes)) {
            $this->estornarProjeto($doacao->getRecompensa()->getProjeto());
        }
        
        return $doacao;
    }
    
    /**
     * @param Projeto $projeto
     */
    private function estornarProjeto(Projeto $projeto)
    {
        $em = $this->getEntityManager();
        
        $status = $em->find('EmVistaBundle:StatusFinanceiro', StatusFinanceiro::STATUS_ESTORNADO);
        
        $projeto->setStatusFinanceiro($status);
        
        $em->persist($projeto);
        $em->flush();
    }
}
