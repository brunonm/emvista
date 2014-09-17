<?php

namespace EmVista\EmVistaBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\ProjetoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\ProjetoNaoPublicadoException;
use EmVista\EmVistaBundle\Services\Exceptions\ProjetoNaoEncontradoException;

class ProjetoController extends ControllerAbstract
{
    /**
     * A rota dessa action foi definida no routing.yml
     */
    public function visualizarAction($projetoSlug)
    {
        // para visualizar, precisar estar publicado

        try {
            $usuario = $this->getUser();

            $service = $this->get('service.projeto');

            $sd = ServiceData::build(array('slug' => $projetoSlug))->setUser($usuario);

            $projeto = $service->getProjetoBySlug($sd);

            if (false == $projeto->getPublicado()) {
                throw new ProjetoNaoPublicadoException();
            }

            $atualizacoes = $service->listarAtualizacoes(ServiceData::build()->set('projetoId', $projeto->getId()));

            $countDoacoes = $service->countDoacoes(ServiceData::build()->set('projetoId', $projeto->getId()));

            $hasUsuarioDoacao = $service->hasDoacaoUsuarioProjeto(ServiceData::build()->set('projetoId', $projeto->getId())
                                                                                      ->setUser($usuario));

            return $this->render('EmVistaBundle:Projeto:visualizar.html.php', array(
                    'projeto' => $projeto,
                    'usuario' => $usuario,
                    'countDoacoes' => $countDoacoes,
                    'hasUsuarioDoacao' => $hasUsuarioDoacao,
                    'atualizacoes' => $atualizacoes));

        } catch (ProjetoNaoEncontradoException $e) {
            $this->setWarningMessage(ProjetoMessages::PROJETO_NAO_ENCONTRADO);

            return $this->redirect($this->generateUrl('home_index'));

        } catch (ProjetoNaoPublicadoException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/projeto/salvar-atualizacao", name="projeto_salvarAtualizacao")
     */
    public function salvarAtualizacaoAction()
    {
        $sd = ServiceData::build($this->getRequest()->get('atualizacao'));
        $projeto = $this->get('service.projeto')->salvarAtualizacao($sd);
        $this->setSuccessMessage(ProjetoMessages::ATUALIZACAO_INSERIDA_SUCESSO);

        return $this->redirect($this->generateUrl('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())));
    }

    /**
     * @Route("/descubra", defaults={"search" = ""}, name="projeto_descubra")
     * @Route("/descubra/", defaults={"search" = ""}, name="projeto_descubra")
     * @Route("/descubra/{search}", name="projeto_descubraComSearch")
     */
    public function descubraAction($search)
    {
        $sd = ServiceData::build(array('search' => $search));
        $projetoService = $this->get('service.projeto');

        $categorias     = $projetoService->listarCategorias();

        if ($search != '') {
            $projetos       = $projetoService->search($sd);
        } else {
            $projetos       = $projetoService->listarProjetosPublicados();
        }

        return $this->render('EmVistaBundle:Projeto:listaProjeto.html.php', array(
                   'categorias' => $categorias,
                   'projetos' => $projetos,
               ));
    }

    /**
     * @Route("/projeto/search/{search}", name="projeto_search")
     */
    public function searchAction($search)
    {
        $sd = ServiceData::build(array('search' => $search));
        $projetoService = $this->get('service.projeto');
        $projetos       = $projetoService->search($sd);
        $retorno = array();
        foreach ($projetos as $indice =>$projeto) {
            $retorno[$indice] = $projeto->toArray();
        }
        $response = new Response(json_encode($retorno));

        return $response;
    }

    /**
     * @Route("/projeto/listar-json", name="projeto_listarJson")
     */
    public function listarJsonAction()
    {
        $projetoService = $this->get('service.projeto');
        $projetos = $projetoService->listarProjetosPublicados();
        foreach ($projetos as $indice =>$projeto) {
            $retorno[$indice] = $projeto->toArray();
        }
        $response = new Response(json_encode($retorno));

        return $response;
    }

}
