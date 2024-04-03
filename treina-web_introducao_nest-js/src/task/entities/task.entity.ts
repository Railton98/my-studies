import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity({ name: 'tasks' })
export class Task {
  @PrimaryGeneratedColumn('increment')
  id: number;

  @Column({ nullable: false })
  titulo: string;

  @Column({ nullable: false })
  descricao: string;

  @Column({ nullable: false })
  status: number;
}
