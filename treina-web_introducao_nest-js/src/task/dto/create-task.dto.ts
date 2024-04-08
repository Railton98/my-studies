import { IsString, Length } from 'class-validator';

export class CreateTaskDto {
  @IsString({ message: 'O campo Título deve ser uma string' })
  @Length(3, 10, { message: 'O campo Título deve ter entre 3 e 10 caracteres' })
  titulo: string;

  @IsString({ message: 'O campo Descrição deve ser uma string' })
  @Length(3, 150, {
    message: 'O campo Descrição deve ter entre 3 e 150 caracteres',
  })
  descricao: string;
}
