<?php

namespace EmVista\EmVistaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\ProjetoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\ProjetoNaoPublicadoException;
use EmVista\EmVistaBundle\Services\Exceptions\ProjetoNaoEncontradoException;
use Symfony\Component\HttpFoundation\JsonResponse;

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


            $sd = ServiceData::build(array('projetoId' => $projeto->getId()));
            $apoiadores = $this->get('service.projeto')->listApoiadoresProjeto($sd);

            return $this->render('EmVistaBundle:Projeto:visualizar.html.php',
                array(
                    'projeto' => $projeto,
                    'usuario' => $usuario,
                    'countDoacoes' => $countDoacoes,
                    'hasUsuarioDoacao' => $hasUsuarioDoacao,
                    'atualizacoes' => $atualizacoes,
                    'apoiadores' => $apoiadores
                )
            );

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
     * @return Response
     */
    public function descubraAction($search)
    {
        $sd = ServiceData::build(array('search' => $search));
        
        $projetoService = $this->get('service.projeto');

        $categorias = $projetoService->listarCategorias();

        if ($search != '') {
            $projetos = $projetoService->search($sd);
        } else {
            $projetos = $projetoService->listarProjetosPublicados();
        }

        return $this->render(
            'EmVistaBundle:Projeto:listaProjeto.html.php', 
            array(
                'categorias' => $categorias,
                'projetos' => $projetos,
            )
        );
    }

    /**
     * @Route("/projeto/search/{search}", name="projeto_search")
     */
    public function searchAction($search)
    {
        $sd = ServiceData::build(array('search' => $search));
        $projetos = $this->get('service.projeto')->search($sd);
        $retorno = array();
        foreach ($projetos as $indice =>$projeto) {
            $retorno[$indice] = $projeto->toArray();
        }
        return new JsonResponse($retorno);
    }

    public function getMoreAction(Request $request)
    {
        $sd = ServiceData::build($request->request->all());
        $count = $sd->get('count');
        $projetos = $this->get('service.projeto')->getMore($sd);
        $count -= count($projetos);
        if ($count > 0) {
            $sd->set('count', $count);
            $sd->set('preCadastro', true);
            $projetos = array_merge($projetos, $this->get('service.projeto')->getMore($sd));
        }
        $retorno = array();
        foreach ($projetos as $indice =>$projeto) {
            $retorno[$indice] = $projeto->toArray();
        }
        return new JsonResponse($retorno);
    }
}
