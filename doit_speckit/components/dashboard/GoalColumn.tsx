"use client";

import { Goal } from "@/types/goal";
import { GoalCard } from "./GoalCard";

interface GoalColumnProps {
  title: string;
  goals: Goal[];
  onCompleteGoal: (id: string) => void;
  onDeleteGoal: (id: string) => void;
  isEmpty?: boolean;
}

/**
 * Component to display a column of goals
 * Shows header and list of GoalCard components
 * Displays empty state message when no goals exist
 */
export function GoalColumn({
  title,
  goals,
  onCompleteGoal,
  onDeleteGoal,
}: GoalColumnProps) {
  return (
    <div className="flex flex-col gap-4">
      {/* Column header */}
      <div className="flex items-center gap-2">
        <h2 className="text-lg font-bold text-gray-900">{title}</h2>
        <span className="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">
          {goals.length}
        </span>
      </div>

      {/* Goals list or empty state */}
      <div className="flex flex-col gap-3">
        {goals.length === 0 ? (
          <div className="rounded-lg border-2 border-dashed border-gray-300 p-6 text-center">
            <p className="text-sm text-gray-500">
              {title === "Current Goals"
                ? "No goals yet. Click 'Add Goal' to get started!"
                : "No completed goals yet."}
            </p>
          </div>
        ) : (
          goals.map((goal) => (
            <GoalCard
              key={goal.id}
              goal={goal}
              onComplete={onCompleteGoal}
              onDelete={onDeleteGoal}
            />
          ))
        )}
      </div>
    </div>
  );
}
