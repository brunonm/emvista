<?php

namespace EmVista\EmVistaBundle\Services;

use EmVista\EmVistaBundle\Util\Money;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImagineInterface;
use EmVista\EmVistaBundle\Util\Date;
use EmVista\EmVistaBundle\Entity\Email;
use EmVista\EmVistaBundle\Entity\Video;
use EmVista\EmVistaBundle\Entity\Pessoa;
use EmVista\EmVistaBundle\Entity\Imagem;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\Categoria;
use EmVista\EmVistaBundle\Entity\SiteVideo;
use EmVista\EmVistaBundle\Entity\Submissao;
use EmVista\EmVistaBundle\Entity\Recompensa;
use EmVista\EmVistaBundle\Entity\ProjetoImagem;
use EmVista\EmVistaBundle\Entity\StatusSubmissao;
use EmVista\EmVistaBundle\Entity\TipoProjetoImagem;
use EmVista\EmVistaBundle\Entity\StatusArrecadacao;
use EmVista\EmVistaBundle\Messages\SubmissaoMessages;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceAbstract;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Services\Exceptions\VideoInvalidoException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\VideoErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\ImagensErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\DescricaoErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\PermissaoNegadaException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\RecompensasErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\DadosBasicosErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\MaisSobreVoceErrorException;

class SubmissaoService extends ServiceAbstract
{
    /**
     * @var string
     */
    private $uploadDir;

    /**
     * @var ProjetoService
     */
    private $projetoService;
    
    /**
     * @var ImagineInterface
     */
    private $imagine;

    /**
     * @param integer
     */
    private $quantidadeDiasMinimo = 10;

    /**
     * @param integer
     */
    private $quantidadeDiasMaximo = 60;

    /**
     * @var string
     */
    private $contatoEmail;

    /**
     * @return string
     */
    public function getContatoEmail()
    {
        return $this->contatoEmail;
    }

    /**
     * @param string $contatoEmail
     */
    public function setContatoEmail($contatoEmail)
    {
        $this->contatoEmail = $contatoEmail;
    }



    /**
     * @param ProjetoService
     * @return SubmissaoService
     */
    public function setProjetoService(ProjetoService $projetoService)
    {
        $this->projetoService = $projetoService;

        return $this;
    }

    /**
     * @param  ImagineInterface $imagine
     * @return SubmissaoService
     */
    public function setImagine(ImagineInterface $imagine)
    {
        $this->imagine = $imagine;

        return $this;
    }

    /**
     * @param  string           $uploadDir
     * @return SubmissaoService
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    /**
     * seta a quantidade de dias minimo que o projeto pode ficar ficar no site
     * @param integer $qtd
     */
    public function setQuantidadeDiasMinimo($qtd)
    {
        $this->quantidadeDiasMinimo = $qtd;

        return $this;
    }

    /**
     * seta a quantidade de dias minima que o projeto pode ficar ficar no site
     * @param integer $qtd
     */
    public function setQuantidadeDiasMaximo($qtd)
    {
        $this->quantidadeDiasMaximo = $qtd;

        return $this;
    }

    /**
     * @param  ServiceData $sd
     * @param  Usuario     $sd['user']
     * @return Submissao
     */
    public function iniciar(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('user', $v::instance('EmVista\EmVistaBundle\Entity\Usuario'))
                     ->check($sd->get());

            $usuario  = $sd->getUser();
            $termoUso = $this->projetoService->getTermoUsoVigente();

            $projeto = new Projeto();
            $projeto->setUsuario($usuario)
                    ->setTermoUso($termoUso);

            $statusSubmissao = $em->getRepository('EmVistaBundle:StatusSubmissao')
                                  ->findOneBy(array('id' => StatusSubmissao::STATUS_INICIAL));

            $submissao = new Submissao();
            $submissao->setProjeto($projeto)
                      ->setStatus($statusSubmissao);

            $em->persist($projeto);
            $em->persist($submissao);
            $em->flush();
            $em->commit();

            return $submissao;
        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }

        return $submissao;
    }

    /**
     * @param  ServiceData $sd
     * @param  integer     $sd['submissaoId']
     * @return Submissao   | null
     */
    public function getSubmissao(ServiceData $sd)
    {
        try {
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int())->check($sd->get());

            $em = $this->getEntityManager();

            return $em->getRepository('EmVistaBundle:Submissao')->findOneBy(array('id' => $sd->get('submissaoId')));

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        }
    }

    /**
     * Retorna os dados necessarios para os dados basicos do projeto
     * @return mixed[]
     */
    public function dadosBasicos()
    {
        $dadosBasicos['categorias']           = $this->projetoService->listarCategorias();
        $dadosBasicos['quantidadeDiasMinimo'] = $this->quantidadeDiasMinimo;
        $dadosBasicos['quantidadeDiasMaximo'] = $this->quantidadeDiasMaximo;

        return $dadosBasicos;
    }

    /**
     * Salva os dados basicos do projeto
     * @param ServiceData $sd
     * @param integer     $sd['submissaoId']
     * @param integer     $sd['categoriaId']
     * @param integer     $sd['quantidadeDias']
     * @param float       $sd['valor']
     * @param string      $sd['nome']
     */
    public function salvarDadosBasicos(ServiceData $sd)
    {
        $em = $this->getEntityManager();

        try {
            
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->key('categoriaId', $v::int()->positive())
                     ->key('nome', $v::string()->length(3, 255)->notEmpty())
                     ->key('quantidadeDias', $v::int()->min($this->quantidadeDiasMinimo, true)->max($this->quantidadeDiasMaximo, true))
                     ->check($sd->get());
            
            if ($sd->offsetExists('preCadastro') && $sd->get('preCadastro')) {
                $preCadastro = true;
                $valor = 0;
            } else {
                if (!$sd->get('valor')) {
                    throw new \InvalidArgumentException('Valor Inválido');
                }
                $preCadastro = false;
                $valor = Money::revert($sd->get('valor'));
            }

            $categoria = $em->find('EmVistaBundle:Categoria', $sd->get('categoriaId'));

            $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));

            ##### VERIFICAR NUMBER FORMAT DO VALOR

            $projeto = $submissao->getProjeto()
                                 ->setCategoria($categoria)
                                 ->setNome(trim($sd->get('nome')))
                                 ->setQuantidadeDias($sd->get('quantidadeDias'))
                                 ->setValor($valor)
                                 ->setPreCadastro($preCadastro);
            
            $em->persist($projeto);
            $em->flush();

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Salva as descricoes do projeto
     * @param ServiceData $sd
     * @param integer     $sd['submissaoId']
     * @param string      $sd['descricao']
     * @param string      $sd['descricaoCurta']
     */
    public function salvarDescricao(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->key('descricao', $v::string()->length(200)->notEmpty())
                     ->key('descricaoCurta', $v::string()->length(3, 130)->notEmpty())
                     ->check($sd->get());

            $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));

            ### TESTAR TIDY NO FUTURO
            $descricao = strip_tags(trim($sd->get('descricao')));

            $projeto = $submissao->getProjeto()
                                 ->setDescricao($descricao)
                                 ->setDescricaoCurta(trim($sd->get('descricaoCurta')));

            $em->persist($projeto);
            $em->flush();
            $em->commit();

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * Salva as recompensas do projeto
     * @param ServiceData $sd
     * @param int         $sd['submissaoId']
     * @param mixed[]     $sd['recompensas']
     * @param string      $sd['recompensas'][]['descricao']
     * @param string      $sd['recompensas'][]['titulo']
     * @param float       $sd['recompensas'][]['valorMinimo']
     * @param int         $sd['recompensas'][]['quantidadeMaximaApoiadores']
     * @return Submissao
     */
    public function salvarRecompensas(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $data = $sd->get();
            
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->key('recompensas', $v::arr()
                     ->each($v::arr()->key('descricao', $v::string()->length(3)->notEmpty())
                                     ->key('titulo', $v::string()->length(3, 100)->notEmpty())
                                     ->key('valorMinimo', $v::positive()->notEmpty())
                                     ->key('quantidadeMaximaApoiadores', $v::oneOf($v::int()->positive(), $v::nullValue(), $v::equals('')), false)
                                     ->key('recompensaId', $v::oneOf($v::int()->positive(), $v::nullValue(), $v::equals('')), false)))
                     ->check($data);

            $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));
            $projeto   = $submissao->getProjeto();

            $ids = array();

            # adiciona e atualiza as recompensas
            foreach ($data['recompensas'] as $recompensaData) {
                if (array_key_exists('recompensaId', $recompensaData) && !empty($recompensaData['recompensaId'])) {
                    $ids[] = $recompensaData['recompensaId'];
                    $recompensa = $em->find('EmVistaBundle:Recompensa', $recompensaData['recompensaId']);
                } else {
                    $recompensa = new Recompensa();
                }

                ##### VERIFICAR NUMBER FORMAT DO VALOR

                $recompensa->setDescricao($recompensaData['descricao'])
                           ->setTitulo($recompensaData['titulo'])
                           ->setProjeto($projeto)
                           ->setValorMinimo(Money::revert($recompensaData['valorMinimo']))
                           ->setQuantidadeMaximaApoiadores(null);

                if (array_key_exists('quantidadeMaximaApoiadores', $recompensaData) && !empty($recompensaData['quantidadeMaximaApoiadores'])) {
                    $recompensa->setQuantidadeMaximaApoiadores($recompensaData['quantidadeMaximaApoiadores']);
                }

                $em->persist($recompensa);
            }

            # remove as recompensas que nao existem mais
            $recompensasExcluir = $em->getRepository('EmVistaBundle:Recompensa')->listarRecompensasNotIn($ids, $projeto);
            foreach ($recompensasExcluir as $recompensa) {
                $em->remove($recompensa);
            }

            $em->persist($projeto);
            $em->flush();
            $em->commit();

            return $submissao;
            
        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @return SiteVideo[]
     */
    public function getSitesVideo()
    {
        return $this->getEntityManager()->getRepository('EmVistaBundle:SiteVideo')->findAll();
    }

    /**
     * @param ServiceData $sd
     * @param integer     $sd['submissaoId']
     * @param integer     $sd['siteVideoId']
     * @param string      $sd['url']
     */
    public function salvarVideo(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->key('siteVideoId', $v::int()->positive())
                     ->key('url', $v::string()->length(3))
                     ->check($sd->get());

            $siteVideo = $em->find('EmVistaBundle:SiteVideo', $sd->get('siteVideoId'));

            $identificador = $this->parseIdentificador($sd->get('url'), $siteVideo);

            $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));

            $projeto = $submissao->getProjeto();

            $video = $projeto->getVideo();

            if (!$video instanceof Video) {
                $video = new Video();
            }

            $video->setIdentificador($identificador)
                  ->setSiteVideo($siteVideo);

            $projeto->setVideo($video);

            $em->persist($video);
            $em->persist($projeto);
            $em->flush();
            $em->commit();

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param string    $url
     * @param SiteVideo $siteVideo
     */
    private function parseIdentificador($url, $siteVideo)
    {
        if (false === stripos($url, $siteVideo->getNome())) {
            throw new VideoInvalidoException('Por favor, verifique o video informado novamente.');
        }

        $url    = trim($url);
        $site   = ucfirst(strtolower($siteVideo->getNome()));
        $method = "parse{$site}";

        return $this->$method($url);
    }

    /**
     * @param  string                 $url
     * @throws VideoInvalidoException
     */
    private function parseYoutube($url)
    {
        $parse = parse_url($url);
        parse_str($parse['query'], $params);

        if (false === array_key_exists('v', $params) || empty($params['v'])) {
            throw new VideoInvalidoException();
        }

        return $params['v'];
    }

    /**
     * @param  string                 $url
     * @throws VideoInvalidoException
     */
    private function parseVimeo($url)
    {
        $parts = explode('.com/', $url);

        // lança exception se nao conseguir explodir
        if (count($parts) < 2) {
            throw new VideoInvalidoException();
        }

        $identificador = end($parts);

        if (empty($identificador)) {
            throw new VideoInvalidoException();
        }

        return $identificador;
    }

    /**
     * @param ServiceData  $sd
     * @param UploadedFile $sd['file']
     * @param integer      $sd['projetoId']
     * @param Usuario      $sd['user']
     *
     * @return ProjetoImagem
     */
    public function salvarImagemOriginal(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->key('file', $v::instance('Symfony\Component\HttpFoundation\File\UploadedFile'))
                     ->key('user', $v::instance('EmVista\EmVistaBundle\Entity\Usuario'))
                     ->check($sd->get());

            // validar o tamanho em MB
            // valor minimo X = 430 Y = 150
            // validar o limite de tamanho do php

            $uploadedFile      = $sd->get('file');
            $submissao         = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));
            $projeto           = $submissao->getProjeto();
            $tipoProjetoImagem = $em->find('EmVistaBundle:TipoProjetoImagem', TipoProjetoImagem::TIPO_ORIGINAL);
            $imagem            = new Imagem();
            $projetoImagem     = new ProjetoImagem();

            if ($uploadedFile->getSize() / 1024 > 2048) {
                throw new ServiceValidationException('Tamanho máximo excedido.');
            }

            # se for o segundo upload, apaga todas as imagens ja existentes. Essa regra precisa ser revisada no futuro
            # pra possibilidar ter multiplos uploads por projeto
            $this->removerImagens($projeto);

            $this->populateImageObjects($imagem, $uploadedFile, $projetoImagem, $tipoProjetoImagem, $projeto, $sd->getUser());

            $em->persist($imagem);
            $em->persist($projetoImagem);
            $em->flush();

            $mimeType = exif_imagetype($uploadedFile->getRealPath());

            if (false === $uploadedFile->isValid() || false === in_array($mimeType, array(IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
                throw new ServiceValidationException('Imagem ou formato inválido.');
            }

            $dir = $this->uploadDir . DIRECTORY_SEPARATOR . md5($projeto->getId());

            if (false === file_exists($dir)) {
                if (false === mkdir($dir)) {
                    throw new \Exception('Permissão negada.');
                }
            }

            $uploadedFile->move($dir, md5($imagem->getId()) . '.' . $uploadedFile->guessExtension());

            $em->commit();

            return $projetoImagem;

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * Remove todas as imagens existentes de um projeto
     * @param Projeto $projeto
     */
    private function removerImagens($projeto)
    {
        $em = $this->getEntityManager();
        $imagens = $em->getRepository('EmVistaBundle:ProjetoImagem')->findBy(array('projeto' => $projeto->getId()));
        foreach ($imagens as $projetoImagem) {
            $ds = DIRECTORY_SEPARATOR;
            $filePath = $this->uploadDir . $ds . md5($projeto->getId()) . $ds . $projetoImagem->getImagem()->getFilename();
            unlink($filePath);
            $em->remove($projetoImagem->getImagem());
            $em->remove($projetoImagem);
        }
    }

    /**
     * @param Imagem            $imagem
     * @param UploadedFile      $uploadedFile
     * @param ProjetoImagem     $projetoImagem
     * @param TipoProjetoImagem $tipoProjetoImagem
     * @param Projeto           $projeto
     * @param Usuario           $usuarioSession
     */
    private function populateImageObjects($imagem, $uploadedFile, $projetoImagem, $tipoProjetoImagem, $projeto, $usuarioSession)
    {
        $imageInfo = getimagesize($uploadedFile->getRealPath());

        $imagem->setLargura($imageInfo[0])
               ->setAltura($imageInfo[1])
               ->setExtensao($uploadedFile->guessExtension())
               ->setOriginalFilename($uploadedFile->getClientOriginalName())
               ->setSize($uploadedFile->getSize())
               ->setUsuario($usuarioSession);

        $projetoImagem->setImagem($imagem)
                      ->setProjeto($projeto)
                      ->setTipoProjetoImagem($tipoProjetoImagem);
    }

    /**
     * @param ServiceData $sd
     * @param int         $sd['projetoImagemId']
     * @param int         $sd['tipoProjetoImagemId']
     * @param float       $sd['x']
     * @param float       $sd['y']
     * @param float       $sd['w']
     * @param float       $sd['h']
     *
     * @return ProjetoImagem
     */
    public function crop(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('projetoImagemId', $v::int()->positive())
                     ->key('tipoProjetoImagemId', $v::int()->positive())
                     ->key('x', $v::numeric())
                     ->key('y', $v::numeric())
                     ->key('w', $v::numeric())
                     ->key('h', $v::numeric())
                     ->key('imageH', $v::numeric())
                     ->key('imageW', $v::numeric())
                     ->check($sd->get());

            $tipoProjetoImagemDestaque = $em->find('EmVistaBundle:TipoProjetoImagem', $sd->get('tipoProjetoImagemId'));

            $aspectRatio = round($sd->get('w') / $sd->get('h'), 1);

            if ($aspectRatio != round($tipoProjetoImagemDestaque->getAspectRatio(), 1)) {
                throw new \InvalidArgumentException('O aspect ratio do crop é incorreto para este destaque');
            }

            $projetoImagem = $em->find('EmVistaBundle:ProjetoImagem', $sd->get('projetoImagemId'));
            /**
             * @var Imagem $imagem
             */
            $imagem = $projetoImagem->getImagem();

            $ratioImagem = $imagem->getLargura() / $sd->get('imageW');


            $projetoUploadDir = $this->uploadDir . '/' . md5($projetoImagem->getProjeto()->getId());

            $filename = $projetoUploadDir . '/' . $projetoImagem->getImagem()->getFilename();

            $imagine = $this->imagine->open($filename);

            $sd->set('x', round($sd->get('x') * $ratioImagem), 1);
            $sd->set('y', round($sd->get('y') * $ratioImagem), 1);
            $sd->set('w', round($sd->get('w') * $ratioImagem), 1);
            $sd->set('h', round($sd->get('h') * $ratioImagem), 1);

            $imagine->crop(new Point($sd->get('x') , $sd->get('y') ), new Box($sd->get('w') , $sd->get('h') ));

            $cropImagem = new Imagem();
            $cropImagem->setAltura($sd->get('h') )
                       ->setLargura($sd->get('w') )
                       ->setExtensao($imagem->getExtensao())
                       ->setOriginalFilename($imagem->getOriginalFilename())
                       ->setSize(100)
                       ->setUsuario($imagem->getUsuario());

            $cropProjetoImagem = new ProjetoImagem();
            $cropProjetoImagem->setImagem($cropImagem)
                              ->setProjeto($projetoImagem->getProjeto())
                              ->setTipoProjetoImagem($tipoProjetoImagemDestaque);

            $em->persist($cropImagem);
            $em->persist($cropProjetoImagem);
            $em->flush();

            $newFilename = $projetoUploadDir . '/' . $cropImagem->getFilename();

            $imagine->save($newFilename);

            # atualiza o size do crop no banco de dados
            $cropImagem->setSize(filesize($newFilename));
            $em->persist($cropImagem);
            $em->flush();

            $em->commit();

            return $cropProjetoImagem;

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @return string[]
     */
    public function getCropParams()
    {
        $em = $this->getEntityManager();
        $tiposProjetoImagem = $em->getRepository('EmVistaBundle:TipoProjetoImagem')->findAll();

        $res = array();
        foreach ($tiposProjetoImagem as $tipoProjetoImagem) {
            if ($tipoProjetoImagem->getId() == TipoProjetoImagem::TIPO_ORIGINAL) {
                continue;
            }
            $res[$tipoProjetoImagem->getId()] = array(
                'id' => $tipoProjetoImagem->getId(),
                'nome' => $tipoProjetoImagem->getNome(),
                'aspectRatio' => $tipoProjetoImagem->getAspectRatio(),
                'largura' => $tipoProjetoImagem->getLargura(),
                'altura' => $tipoProjetoImagem->getAltura()
            );
        }

        return $res;
    }

    /**
     * Salva os dados legais da pessoa
     * @param ServiceData $sd
     * @param string      $sd['tipoPessoa']
     * @param string      $sd['documento']
     * @param string      $sd['nome']
     * @param Usuario     $sd['user']
     */
    public function salvarMaisSobreVoce(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {

            $projeto = $em
                ->find('EmVistaBundle:Submissao', $sd->get('submissaoId'))
                ->getProjeto();
            
            if ($projeto->getPreCadastro()) {
                
                $v = $this->getValidator();
                $v::arr()->key('nome', $v::string()->max(255))
                         ->check($sd->get());   
                
               $projeto->setNomeAutorPreCadastro($sd->get('nome'));
               
               $em->persist($projeto);
               
            } else {
                
                $v = $this->getValidator();
                $v::arr()->key('tipoPessoa', $v::oneOf($v::equals('j'), $v::equals('f')))
                         ->key('documento', $v::oneOf($v::cpf(), $v::cnpj())->notEmpty())
                         ->key('nome', $v::string()->max(255))
                         ->key('user', $v::instance('EmVista\EmVistaBundle\Entity\Usuario'))
                         ->check($sd->get());
                
                $usuario = $sd->getUser();
                $pessoa  = $em->getRepository('EmVistaBundle:Pessoa')->findOneBy(array('usuario' => $usuario->getId()));

                if (empty($pessoa)) {
                    $documento = preg_replace("/[^0-9\s]/", "", $sd->get('documento'));

                    $pessoa = new Pessoa();
                    $pessoa->setDocumento($documento)
                           ->setUsuario($usuario)
                           ->setTipo($sd->get('tipoPessoa'))
                           ->setNome($sd->get('nome'));

                    $em->persist($pessoa);
                }
            }
            
            $em->flush();
            $em->commit();

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param  ServiceData                $sd
     * @param  integer                    $sd['submissaoId']
     * @throws ServiceValidationException
     * @throws InvalidArgumentException
     */
    public function concluir(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->check($sd->get());

            $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));

            # verifica se todos os passos foram feitos com sucesso e controla erros atraves de exceptions
            $this->validaDadosBasicos($submissao);
            $this->validaDescricao($submissao);
            $this->validaRecompensas($submissao);
            $this->validaVideo($submissao);
            $this->validaImagens($submissao);
            $this->validaMaisSobreVoce($submissao);

            $status = $em->find('EmVistaBundle:StatusSubmissao', StatusSubmissao::STATUS_AGUARDANDO_APROVACAO);

            $submissao->setStatus($status)
                      ->setDataEnvio(new \DateTime('now'));

            $em->persist($submissao);
            $em->flush();
            $em->commit();
            
            if (!$submissao->getProjeto()->getPreCadastro()) {
                $this->enviaMailConfirmacao($submissao);
            }
            
        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    public function enviaMailConfirmacao(Submissao $submissao)
    {

        $emailRepository = $this->getEntityManager()->getRepository('EmVistaBundle:Email');
        $mailer = $this->getMailer();

        $usuario   = $submissao->getProjeto()->getUsuario();
        $projeto    = $submissao->getProjeto();

        $template = $emailRepository->find(Email::ADMIN_CADASTRO_PROJETO);

        $text = str_replace(array('{USUARIO}', '{NOME-PROJETO}'),
            array($usuario->getNome(), $projeto->getNome()),
            $template->getTexto());

        $mailer->newMessage()
            ->to($this->getContatoEmail())
            ->subject($template->getTitulo())
            ->message($text)
            ->isHtml(true)
            ->send();
    }
    /**
     * @param  Submissao                  $submissao
     * @throws DadosBasicosErrorException
     */
    private function validaDadosBasicos($submissao)
    {
        $projeto = $submissao->getProjeto();
        $nome    = $projeto->getNome();
        $valor   = $projeto->getValor();

        if (empty($nome) || false === ($projeto->getCategoria() instanceof Categoria)) {
            throw new DadosBasicosErrorException(SubmissaoMessages::DADOS_BASICOS_INVALIDO);
        }
        
        if (!$submissao->getProjeto()->getPreCadastro()) {
            if (empty($valor)) {
                throw new DadosBasicosErrorException(SubmissaoMessages::DADOS_BASICOS_INVALIDO);
            }
        }
    }

    /**
     * @param  Submissao               $submissao
     * @throws DescricaoErrorException
     */
    private function validaDescricao($submissao)
    {
        $projeto = $submissao->getProjeto();
        $descricao = $projeto->getDescricao();
        $descricaoCurta = $projeto->getDescricaoCurta();

        if (empty($descricao) || empty($descricaoCurta)) {
            throw new DescricaoErrorException(SubmissaoMessages::DESCRICAO_INVALIDO);
        }

    }

    /**
     * @param  Submissao                 $submissao
     * @throws RecompensasErrorException
     */
    private function validaRecompensas($submissao)
    {
        $projeto = $submissao->getProjeto();

        if (count($projeto->getRecompensas()) < 1) {
            throw new RecompensasErrorException(SubmissaoMessages::RECOMPENSAS_INVALIDO);
        }
    }

    /**
     * @param  Submissao           $submissao
     * @throws VideoErrorException
     */
    private function validaVideo($submissao)
    {
        $video = $submissao->getProjeto()->getVideo();
        if (empty($video)) {
            throw new VideoErrorException(SubmissaoMessages::VIDEO_INVALIDO);
        }
    }

    /**
     * @param  Submissao             $submissao
     * @throws ImagensErrorException
     */
    private function validaImagens($submissao)
    {
        $projeto = $submissao->getProjeto();
        $em = $this->getEntityManager();

        $imagens = $em->getRepository('EmVistaBundle:ProjetoImagem')->findBy(array('projeto' => $projeto->getId()));

        if (count($imagens) != 2) {
            throw new ImagensErrorException(SubmissaoMessages::IMAGENS_INVALIDO);
        }
    }

    /**
     * @param  Submissao                   $submissao
     * @throws MaisSobreVoceErrorException
     */
    private function validaMaisSobreVoce($submissao)
    {
        if (!$submissao->getProjeto()->getPreCadastro()) {
            $usuario = $submissao->getProjeto()->getUsuario();
            $em = $this->getEntityManager();

            $pessoa = $em->getRepository('EmVistaBundle:Pessoa')->findOneBy(array('usuario' => $usuario->getId()));

            $msg = SubmissaoMessages::MAIS_SOBRE_VOCE_INVALIDO;

            if (empty($pessoa)) {
                throw new MaisSobreVoceErrorException($msg);
            }

            $documento = $pessoa->getDocumento();
            $nome = $pessoa->getNome();

            if (empty($documento) || empty($nome)) {
                throw new MaisSobreVoceErrorException($msg);
            }
        }
    }

    /**
     * @param ServiceData $sd
     * @param Usuario     $sd['user']
     * @param integer     $sd['submissaoId']
     */
    public function verifyPermission(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));
        $projeto = $submissao->getProjeto();

        if ($projeto->getUsuario()->getId() != $sd->getUser()->getId()) {
            throw new PermissaoNegadaException();
        }
        
        if ($submissao->isRejeitada() || ($projeto->getStatusArrecadacao() != null && !$projeto->isArrecadando())) {
            throw new PermissaoNegadaException();
        }
    }

    /**
     * @return Submissao[]
     */
    public function listarSubmissoesAguardandoAprovacao()
    {
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Submissao')
                    ->findBy(array('status' => StatusSubmissao::STATUS_AGUARDANDO_APROVACAO), array('dataEnvio' => 'DESC'));
    }

    /**
     * @param ServiceData $sd
     * @param int         $sd['submissaoId']
     * @param int         $sd['statusSubmissaoId']
     * @param string      $sd['observacaoResposta']
     */
    public function avaliarSubmissao(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $observacao = $sd->offsetExists('observacaoResposta') ? $sd->get('observacaoResposta') : '';
            if (empty($observacao)) {
                $sd->offsetUnset('observacaoResposta');
            }

            $v = $this->getValidator();
            $v::arr()->key('submissaoId', $v::int()->positive())
                     ->key('observacaoResposta', $v::length(2), false)
                     ->key('statusSubmissaoId', $v::oneOf($v::equals(StatusSubmissao::STATUS_APROVADO),
                                                          $v::equals(StatusSubmissao::STATUS_REJEITADO)))
                     ->check($sd->get());

            $status    = $em->find('EmVistaBundle:StatusSubmissao', $sd->get('statusSubmissaoId'));
            $submissao = $em->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));
            $projeto   = $submissao->getProjeto();

            $submissao->setStatus($status);

            if ($status->getId() == StatusSubmissao::STATUS_APROVADO) {
                $dataAprovacao = new Date('now');
                $dataInicio = new Date('now');
                $dataFim = Date::buildDateInFuture($projeto->getQuantidadeDias())->setTime(23, 59, 59);
                
                if ($projeto->getPreCadastro()) {
                    $statusArrecadacao = $em->find('EmVistaBundle:StatusArrecadacao', StatusArrecadacao::STATUS_AGUARDANDO_INICIO);
                } else {
                    $statusArrecadacao = $em->find('EmVistaBundle:StatusArrecadacao', StatusArrecadacao::STATUS_EM_ANDAMENTO);
                }                
                
                # APROVA, PUBLICA E INICIA O PROJETO
                $projeto->setDataInicio($dataInicio)
                        ->setDataFim($dataFim)
                        ->setDataAprovacao($dataAprovacao)
                        ->setPublicado(true)
                        ->setStatusArrecadacao($statusArrecadacao);

            } elseif ($status->getId() == StatusSubmissao::STATUS_REJEITADO) {
                $submissao->setObservacaoResposta($sd->get('observacaoResposta'))
                          ->setDataResposta(new Date('now'));
            }

            # ENVIAR EMAIL PRO AUTOR

            $em->persist($projeto);
            $em->persist($submissao);
            $em->flush();
            $em->commit();

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param  ServiceData $sd
     * @param  Usuario     $sd['user']
     * @return Submissao[]
     */
    public function listarSubmissoesPorUsuario(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        try {
            $v = $this->getValidator();
            $v::arr()->key('user', $v::instance('EmVista\EmVistaBundle\Entity\Usuario'))
                     ->check($sd->get());

            return $em->getRepository('EmVistaBundle:Submissao')->listarSubmissoesPorUsuario($sd->getUser());

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        }
    }

    /**
     * @param ServiceData $sd
     */
    public function enviarEmailSubmissao(ServiceData $sd)
    {
        try {
            $v = $this->getValidator();
            $v::arr()->key('nome', $v::string())
                     ->key('email', $v::email())
                     ->key('titulo', $v::string())
                     ->key('descricao', $v::string())
                     ->check($sd->get());

            $em = $this->getEntityManager();

            # ENVIO EMAIL CONFIRMACAO

            $emailRepository = $em->getRepository('EmVistaBundle:Email');
            $mailer = $this->getMailer();

            $template = $emailRepository->find(Email::AUTOR_CONFIRMACAO_PRE_CADASTRO);

            $text = str_replace(array('{NOME}'),
                                array($sd->get('nome')),
                                $template->getTexto());

            $mailer->newMessage()
                   ->to($sd->get('email'))
                   ->subject($template->getTitulo())
                   ->message($text)
                   ->isHtml(true)
                   ->send();

            # ENVIO EMAIL PRE CADASTRO

            $emailRepository = $em->getRepository('EmVistaBundle:Email');
            $mailer = $this->getMailer();

            $template = $emailRepository->find(Email::ADMIN_CADASTRO_PRE_PROJETO);

            $text = str_replace(array('{NOME}', '{EMAIL}', '{TITULO}', '{DESCRICAO}', '{DATETIME}'),
                                array($sd->get('nome'), $sd->get('email'), $sd->get('titulo'), $sd->get('descricao'), date('d/m/Y H:i:s')),
                                $template->getTexto());

            $text = nl2br($text);

            $mailer->newMessage()
                   ->to('contato@emvista.me')
                   ->subject($template->getTitulo() . ' - ' . $sd->get('titulo'))
                   ->message($text)
                   ->isHtml(true)
                   ->send();

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e->getMessage());
        }
    }
}
